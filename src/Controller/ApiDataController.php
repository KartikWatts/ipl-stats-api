<?php


namespace App\Controller;


use App\Repository\PlayersDataRepository;
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
    private $squads_data;

    public function __construct(PlayersDataRepository $playerRepository, TeamsDataRepository $teamsRepository)
    {
        $this->playerRepository= $playerRepository;
        $this->teamsRepository= $teamsRepository;
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


    /**
     * @Route("/api/player-details/{id}", methods={"GET"})
     * @param $id
     * @return JsonResponse
     */
    public function get_player_details($id) :JsonResponse{
        $this->check_service_availability();

        $player=$this->playerRepository->findOneBy(['player_id'=> intval($id)]);
        if($player==null){
            $payload=[
                'error'=>"404",
                'message'=>"Data not found!"
            ];
            return new JsonResponse($payload, Response::HTTP_NOT_FOUND);
        }

        $data=[
                'player_id'=> $player->getId(),
                'player_name'=> $player->getPlayerName(),
                'team_id'=>$player->getTeamId(),
                'image_url'=> $player->getImageUrl(),
                'matches'=> $player->getMatches(),
                'not_outs'=> $player->getNotOuts(),
                'runs'=> $player->getRuns(),
                'highest_score'=> $player->getHighest(),
                'batting_average'=> $player->getAverage(),
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
            return new JsonResponse("Method not allowed!", Response::HTTP_UNAUTHORIZED);
        }

        $post_data = json_decode($request->getContent(), true);
        $start_range = 0;
        $data_count = 25;

        if(isset($post_data['start_range']))
            $start_range = $post_data['start_range'];
        if(isset($post_data['data_count']))
            $data_count = $post_data['data_count'];

        if(!is_int($start_range) || !is_int($data_count)){
            return new JsonResponse("Range should only be in integers.", Response::HTTP_FORBIDDEN);
        }

        if($data_count> 25)
            $data_count= 25;

        $last_row=$this->playerRepository->getRowCount();

        if($start_range>= $last_row){
            $start_range=$last_row-1;
        }

        if($start_range + $data_count> $last_row){
            $data_count= $last_row-$start_range;
        }

        $players=$this->playerRepository->findPlayersInRange($start_range, $data_count);

        $data=[];
        foreach ($players as $player) {
            $arr= [
                'player_id' => $player->getId(),
                'player_name' => $player->getPlayerName(),
                'team_id' => $player->getTeamId(),
                'image_url' => $player->getImageUrl(),
                'matches' => $player->getMatches(),
                'not_outs' => $player->getNotOuts(),
                'runs' => $player->getRuns(),
                'highest_score' => $player->getHighest(),
                'batting_average' => $player->getAverage(),
                'strike_rate' => $player->getStrikeRate(),
                'hundreds' => $player->getHundreds(),
                'fifties' => $player->getFifties(),
                'sixes' => $player->getSixes(),
                'catches' => $player->getSixes(),
                'overs' => $player->getOvers(),
                'wickets' => $player->getWickets(),
                'bowling_average' => $player->getAverage(),
                'economy' => $player->getEconomy(),
                'four_wickets' => $player->getFourWickets(),
            ];
            array_push($data,$arr);
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

}