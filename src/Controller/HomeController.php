<?php


namespace App\Controller;


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
    );

    /**
     * @Route("/")
     */
    public function home_page(){
        return $this->render("home.html.twig",[]);
//        return new Response("HomePage");
    }

    /**
     * @Route ("/update-data")
     */
    public function update_data(){
        foreach ($this->teams as $team) {
            echo "<h1>Data for ".$team["name"]."</h1>";
            $link=sprintf('https://cricketapi.platform.iplt20.com/tournaments/22399/squads/%d?matchTypes=ALL', $team["id"]);
            echo sprintf("<a href=%s>%s</a><br>", $link, $link);
            $this->team_page($link, $team["name"]);
        }
        return new Response("DataPage");
    }

    /**
     * @Route ("/team-info/{team_link}/{team-name}")
     */
    public function team_page($team_link, $team_name){
        $link= $team_link;

        $json = file_get_contents($link);
        $json_data = json_decode($json, true);
        $json_data=$json_data["ALL"]["players"];
        foreach ($json_data as $data){
            $id=$data["id"];
            $name=str_replace(" ", "-",strtolower($data["fullName"])) ;
            $squad_name=$team_name;
            print("<h3>Getting data for: ".$id."&nbsp". $name."</h3>");
            $this->player_data( $squad_name,$id, $name);
        }
        return new Response("Ram");
    }

    /**
     * @Route ("/player-data/{squad_name}/{id}/{name}")
     */
    public function player_data($squad_name, $id, $name){
        $client= new Client();
        $link= sprintf('https://www.iplt20.com/teams/%s/squad/%s/%s',$squad_name,$id,$name);
        echo sprintf("<a href=%s>%s</a><br>", $link, $link);
        $crawler= $client->request('GET', $link);
        $player= $crawler->filter('.player-hero__name');
        $player->each(function ($node) {
            print($node->text(). "\t");
        });
        print("<br>");
        $data=$crawler->filter('.player-stats-table__highlight');
        if(count($data)==0){
            echo "<h4>Data not found for ".$name."</h4>";
        }
        $data->each(function ($node, $i){
            if($i==0){
                $bat_data= explode(" ",$node->text());
//                var_dump($bat_data);
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
            }
            else if($i==1){
                $bowl_data= explode(" ",$node->text());
                print("Overs: ". (int)(str_replace(',','',$bowl_data[2],)/6)."<br>");
                print("Wickets: ". ($bowl_data[4])."<br>");
                print("Average: ". ($bowl_data[6])."<br>");
                print("Economy: ". ($bowl_data[7])."<br>");
                print("4 Wickets: ". ($bowl_data[9])."<br>");
            }
            print($i. "\t". $node->text(). "<br>");
        });
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