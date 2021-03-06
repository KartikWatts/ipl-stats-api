<?php


namespace App\Controller;


use App\Entity\PlayersData;
use App\Repository\PlayersDataRepository;
use App\Repository\SecretKeysRepository;
use App\Repository\TeamsDataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiDataController extends AbstractController
{
    private $playerRepository;
    private $teamsRepository;
    private $secretRepository;
    private $squads_data;
    private $LIMIT= 30;

    public function __construct(PlayersDataRepository $playerRepository, TeamsDataRepository $teamsRepository, SecretKeysRepository $secretRepository)
    {
        $this->playerRepository= $playerRepository;
        $this->teamsRepository= $teamsRepository;
        $this->secretRepository= $secretRepository;
        $this->squads_data= $this->teamsRepository->findAll();
    }

    public function check_service_availability(){
        if($this->squads_data==null){
            $payload=[
                'error'=>"503",
                'message'=>"Service Unavailable currently!"
            ];
            return new JsonResponse($payload, Response::HTTP_SERVICE_UNAVAILABLE);
        }
        return null;
    }

    /**
     * @Route("/api/squads-list", methods={"GET"})
     */
    public function get_squads_list() :JsonResponse{
        $this->check_service_availability();

        $data=[];
        foreach ($this->squads_data as $squad){
            $arr= [
                'id'=> $squad->getTeamId(),
                'name'=> $squad->getTeamName()
            ];
            array_push($data, $arr);
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }


    /**
     * @Route("/api/squad-details/{id}", methods={"GET"})
     * @param $id
     * @return JsonResponse
     */
    public function get_squad_details($id) :JsonResponse{
        $this->check_service_availability();

        if(!ctype_digit($id)){
            $payload=[
                'error'=>"400",
                'message'=>"Only integer value accepted for id."
            ];
            return new JsonResponse($payload, Response::HTTP_BAD_REQUEST);
        }

        $squad_data=$this->teamsRepository->findOneBy(['team_id'=>$id]);
        if($squad_data==null){
            $payload=[
                'error'=>"404",
                'message'=>"Data not found!"
            ];
            return new JsonResponse($payload, Response::HTTP_NOT_FOUND);
        }

        $data=[];
        $squad=[
                'id'=> $squad_data->getTeamId(),
                'name'=> $squad_data->getTeamName()
            ];
        $data+=['squad'=>$squad, 'players'=>[]];

        $players_data=$this->playerRepository->findBy(['team_id'=>$id]);

        if($players_data==null){
            $payload=[
                'error'=>"404",
                'message'=>"Data not found!"
            ];
            return new JsonResponse($payload, Response::HTTP_NOT_FOUND);
        }

        foreach ($players_data as $player){
            $arr=[
                'player_id'=> $player->getPlayerId(),
                'player_name'=> $player->getPlayerName()
            ];

            array_push($data["players"],(array)$arr);
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    function get_data_array(PlayersData $player) :array{
        $data=[
            'player_id'=> $player->getPlayerId(),
            'player_name'=> $player->getPlayerName(),
            'team_id'=>$player->getTeamId(),
            'image_url'=> $player->getImageUrl(),
            'matches'=> $player->getMatches(),
            'not_outs'=> $player->getNotOuts(),
            'runs'=> $player->getRuns(),
            'highest_score'=> $player->getHighest(),
            'batting_average'=> $player->getBattingAverage(),
            'strike_rate'=> $player->getStrikeRate(),
            'hundreds'=> $player->getHundreds(),
            'fifties'=> $player->getFifties(),
            'sixes'=> $player->getSixes(),
            'catches'=> $player->getSixes(),
            'overs'=> $player->getOvers(),
            'wickets'=> $player->getWickets(),
            'bowling_average'=> $player->getAverage(),
            'economy'=> $player->getEconomy(),
            'four_wickets'=> $player->getFourWickets(),
        ];
        return $data;
    }

    /**
     * @Route("/api/player-details/{id}", methods={"GET"})
     * @param $id
     * @return JsonResponse
     */
    public function get_player_details($id) :JsonResponse{
        $this->check_service_availability();

        if(!ctype_digit($id)){
            $payload=[
                'error'=>"400",
                'message'=>"Only integer value accepted for id."
            ];
            return new JsonResponse($payload, Response::HTTP_BAD_REQUEST);
        }

        $player=$this->playerRepository->findOneBy(['player_id'=> intval($id)]);
        if($player==null){
            $payload=[
                'error'=>"404",
                'message'=>"Data not found!"
            ];
            return new JsonResponse($payload, Response::HTTP_NOT_FOUND);
        }

        $data=$this->get_data_array($player);

        return new JsonResponse($data, Response::HTTP_OK);
    }


    /**
     * @Route("/api/all-players-list", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function get_all_players_list(Request $request) :JsonResponse{
        $this->check_service_availability();

        if(!$request->isMethod('POST')){
            return new JsonResponse("Method not allowed!", Response::HTTP_METHOD_NOT_ALLOWED);
        }

        $post_data = json_decode($request->getContent(), true);
        $start_range = 0;
        $data_count = $this->LIMIT;
        $secret_key="";
        $sort_attr=null;
        $order="desc";
        $team_id=null;

        if(isset($post_data['start_range']))
            $start_range = $post_data['start_range'];
        if(isset($post_data['data_count']))
            $data_count = $post_data['data_count'];
        if(isset($post_data['key']))
            $secret_key= $post_data['key'];
        if(isset($post_data['sort_attr']))
            $sort_attr= $post_data['sort_attr'];
        if(isset($post_data['order']))
            $order= $post_data['order'];
        if(isset($post_data['team_id']))
            $team_id= $post_data['team_id'];

        if(!is_int($start_range) || !is_int($data_count)){
            return new JsonResponse("Range should only be in integers.", Response::HTTP_FORBIDDEN);
        }

        if($team_id && !is_int($team_id)){
            return new JsonResponse("Team_Id should only be in integer.", Response::HTTP_FORBIDDEN);
        }

        if($data_count> $this->LIMIT)
            $data_count= $this->LIMIT;

        $last_row=$this->playerRepository->getRowCount();

        if($start_range>= $last_row){
            $start_range=$last_row-1;
        }

        if($start_range + $data_count> $last_row){
            $data_count= $last_row-$start_range;
        }

        $origin=null;
        if (array_key_exists('HTTP_ORIGIN', $_SERVER)) {
            $origin = $_SERVER['HTTP_ORIGIN'];
        }
        else if (array_key_exists('HTTP_REFERER', $_SERVER)) {
            $origin = $_SERVER['HTTP_REFERER'];
        } else {
            $origin = $_SERVER['REMOTE_ADDR'];
        }

        $admin_data= $this->secretRepository->findOneBy(['secret_key'=>$secret_key]);
        if($admin_data){
            $start_range=0;
            $data_count= $last_row;
            // Allowing localhost for debug
            if(!strpos($origin, "iplt20-stats.herokuapp.com") && !strpos($origin, "127.0.0.1") && !strpos($origin, "localhost" && !strpos($origin, "kartikwatts.github.io/ipl-cards-game")) ){
                return new JsonResponse("Key not allowed for the origin.", Response::HTTP_FORBIDDEN);
            }
        }

        if($order=="asc"){
            $order="ASC";
        }else{
            $order="DESC";
        }

        $players=null;

        if($sort_attr) {
            $sql=null;
            if($sort_attr=="highest"){
                $sql = sprintf("SELECT * FROM players_data P WHERE P.highest IS NOT NULL AND (P.highest!='-') ORDER BY TO_NUMBER(P.highest, '999') %s OFFSET %s LIMIT %s;",$order, $start_range, $data_count);
            }
            else if($sort_attr=="batting_average" || $sort_attr=="bowling_average" ||$sort_attr=="strike_rate" || $sort_attr=="economy"){
                if($sort_attr=="bowling_average")
                    $sort_attr="average";
                $sql= sprintf("SELECT * FROM players_data p WHERE P.%s IS NOT NULL AND (P.%s!='-') ORDER BY CAST(P.%s AS DOUBLE PRECISION) %s OFFSET %s LIMIT %s;",$sort_attr, $sort_attr, $sort_attr, $order,$start_range, $data_count);
            }
            else if($sort_attr=="matches" || $sort_attr=="not_outs" || $sort_attr=="runs" || $sort_attr=="hundreds" || $sort_attr=="fifties" || $sort_attr=="sixes" || $sort_attr=="catches" || $sort_attr=="overs" || $sort_attr=="wickets" || $sort_attr=="four_wickets") {
                $sql= sprintf("SELECT * FROM players_data p WHERE P.%s IS NOT NULL AND (P.%s!='-') ORDER BY CAST(P.%s AS INTEGER) %s OFFSET %s LIMIT %s;",$sort_attr, $sort_attr, $sort_attr, $order,$start_range, $data_count);
            }
            else{
                return new JsonResponse("Sort Attribute is Invalid.", Response::HTTP_BAD_REQUEST);
            }

            if($team_id){
                $substr="ORDER BY";
                $attachment="AND (team_id= ".$team_id.") ".$substr;
                $sql= str_replace($substr, $attachment,$sql);
            }

            $em = $this->getDoctrine()->getManager();
            $query = $em->getConnection()->prepare($sql);
            $query->execute();
            $players= $query->fetchAll();
            $data=[];
            foreach ($players as $player) {
                unset($player["id"]);
                $player["highest_score"] = $player["highest"];
                unset($player["highest"]);
                unset($player["fours"]);
                $player["bowling_average"] = $player["average"];
                unset($player["average"]);

                array_push($data,$player);
            }
            return new JsonResponse($data, Response::HTTP_OK);
        }
        else {
            $players = $this->playerRepository->findPlayersInRange($start_range, $data_count, $team_id);
        }

        $data=[];
        foreach ($players as $player) {
            $arr= $this->get_data_array($player);
            array_push($data,$arr);
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

}