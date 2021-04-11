<?php


namespace App\Controller;


use App\Entity\PlayersData;
use Doctrine\ORM\EntityManagerInterface;
use Goutte\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public $teams= array(
        array("id"=>"1","name"=>"chennai-super-kings"),
        array("id"=>"3","name"=>"delhi-capitals"),
        array("id"=>"5","name"=>"kolkata-knight-riders"),
        array("id"=>"6","name"=>"mumbai-indians"),
        array("id"=>"4","name"=>"punjab-kings"),
        array("id"=>"8","name"=>"rajasthan-royals"),
        array("id"=>"62","name"=>"sunrisers-hyderabad"),
        array("id"=>"9","name"=>"royal-challengers-bangalore")
    );

    /**
     * @Route("/")
     */
    public function home_page(){
        return $this->render("home.html.twig",[]);
    }

    /**
     * @Route ("/update-data")
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function update_data(EntityManagerInterface $entityManager){
        foreach ($this->teams as $team) {
            echo "<h1>Data for ".$team["name"]."</h1>";
            $link=sprintf('https://cricketapi.platform.iplt20.com/tournaments/22399/squads/%d?matchTypes=ALL', $team["id"]);
            echo sprintf("<a href=%s>%s</a><br>", $link, $link);
            $this->team_page($link,$team["id"],$team["name"], $entityManager);
        }
        return new Response("DataPage");
    }

    /**
     * @Route ("/team-info/{team_link}/{team-name}")
     * @param $team_link
     * @param $team_id
     * @param $team_name
     * @param $entityManager
     * @return Response
     */
    public function team_page($team_link, $team_id, $team_name, $entityManager){
        $link= $team_link;

        $json = file_get_contents($link);
        $json_data = json_decode($json, true);
        $json_data=$json_data["ALL"]["players"];
        foreach ($json_data as $data){
            $id=$data["id"];
            $name=str_replace(" ", "-",strtolower($data["fullName"])) ;
            $squad_name=$team_name;
            print("<h3>Getting data for: ".$id."&nbsp". $name."</h3>");
            $this->player_data( $squad_name,$team_id, $id, $name, $entityManager);
        }
        return new Response("Ram");
    }

    /**
     * @Route ("/player-data/{squad_name}/{id}/{name}")
     * @param $squad_name
     * @param $team_id
     * @param $id
     * @param $name
     * @param $entityManager
     * @return Response
     */
    public function player_data($squad_name,$team_id, $id, $name, $entityManager){
        $client= new Client();
        $link= sprintf('https://www.iplt20.com/teams/%s/squad/%s/%s',$squad_name,$id,$name);
        echo sprintf("<a href=%s>%s</a><br>", $link, $link);
        $crawler= $client->request('GET', $link);
        $player_name_data= $crawler->filter('.player-hero__name');
        $player_name="";
        $player_name_data->each(function ($node) use (&$player_name) {
            print($node->text(). "\t");
            $player_name=$node->text();
        });
        print("<br>");
        $repository= $entityManager->getRepository(PlayersData::class);

        $new_data=true;

        $player= $repository->findOneBy(['player_id'=>$id]);
        if($player!=null){
            $new_data=false;
            echo "Player's data already exists<br>";
        }else {
            $player = new PlayersData();
        }
        $image_url=sprintf('https://static.iplt20.com/players/284/%d.png',$id);
        $player->setPlayerId(intval($id))
            ->setTeamId(intval($team_id))
            ->setPlayerName($player_name)
            ->setImageUrl($image_url);


        echo "<div style='display:flex; flex-direction:row; align-self:center; justify-content:start '><img src='".$image_url."' alt='".$player_name."'/>";

        $data=$crawler->filter('.player-stats-table__highlight');
        if(count($data)==0){
            echo "<h4>Data not found for ".$name."</h4>";
            $entityManager->persist($player);

            $entityManager->flush();
            echo"</div>";
            return new Response("Ram");
        }
        $data->each(function ($node, $i) use(&$player){
            if($i==0){
                $bat_data= explode(" ",$node->text());
                print("Matches: ". $bat_data[1]."<br>");
                print("Not outs: ". $bat_data[2]."<br>");
                print("Runs: ". $bat_data[3]."<br>");
                print("Highest: ". $bat_data[4]."<br>");
                print("Average: ". $bat_data[5]."<br>");
                print("Strike Rate: ". $bat_data[7]."<br>");
                print("100s: ". $bat_data[8]."<br>");
                print("50s: ". $bat_data[9]."<br>");
                print("4s: ". $bat_data[10]."<br>");
                print("6s: ". $bat_data[11]."<br>");
                print("Catches: ". $bat_data[12]."<br>");

                $player->setMatches($bat_data[1])
                    ->setNotOuts($bat_data[2])
                    ->setRuns($bat_data[3])
                    ->setHighest($bat_data[4])
                    ->setBattingAverage($bat_data[5])
                    ->setStrikeRate($bat_data[7])
                    ->setHundreds($bat_data[8])
                    ->setFifties($bat_data[9])
                    ->setFours($bat_data[10])
                    ->setSixes($bat_data[11])
                    ->setCatches($bat_data[12]);
            }
            else if($i==1){
                $bowl_data= explode(" ",$node->text());
                $overs=(int)(str_replace(',','',$bowl_data[2])/6);
                print("Overs: ". $overs."<br>");
                print("Wickets: ". ($bowl_data[4])."<br>");
                print("Average: ". ($bowl_data[6])."<br>");
                print("Economy: ". ($bowl_data[7])."<br>");
                print("4 Wickets: ". ($bowl_data[9])."<br>");

                $player->setOvers($overs)
                    ->setWickets($bowl_data[4])
                    ->setAverage($bowl_data[6])
                    ->setEconomy($bowl_data[7])
                    ->setFourWickets($bowl_data[9]);
            }
            print($i. "\t". $node->text(). "<br>");
        });

        $entityManager->persist($player);

        $entityManager->flush();

        echo"</div>";

        if($new_data)
            echo "<h3>New data successfully Inserted</h3>";
        else
            echo "<h3>Data successfully Updated</h3>";

        return new Response("Ram");
    }

    /**
     * @Route("/data")
     */
    public function data_page(){
        $client= new Client();
        $link='https://www.iplt20.com/teams';
        $crawler= $client->request('GET', $link);
        $teams= $crawler->filter('.content-grid > li>a');
        $teams->each(function ($node) {
            $link = $node->link();
            $url1 = $link->getUri();
            $url1= $url1."/squad";
            print($url1 . "<br>");
            $client2 = new Client();
            $crawler2 = $client2->request('GET', $url1);
            $player_data = $crawler2->filter('.playersList li');
            print ($player_data->count());
            $player_data->each(function ($node, $i) {
                print ($i." ".$node->text(). "<br>");
            });
        });
        return new Response("Page for Teams Data");
    }
}