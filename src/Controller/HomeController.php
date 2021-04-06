<?php


namespace App\Controller;


use Goutte\Client;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController
{
//    /**
//     * @Route("/")
//     */
//    public function home_page(){
//        return new Response("HomePage");
//    }
//
//    /**
//     * @Route("/other")
//     */
//    public function other_page(){
//        return new Response("OtherPage");
//    }

    /**
     * @Route ("/ram")
     */
    public function scrap_page(){
        $client= new Client();
        $link= 'https://www.iplt20.com/teams/rajasthan-royals/squad/1154/ben-stokes';
        $crawler= $client->request('GET', $link);
        $player= $crawler->filter('.player-hero__name');
        $player->each(function ($node) {
            print($node->text(). "\t");
        });
        print("<br>");
        $data=$crawler->filter('.player-stats-table__highlight');
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
                print("Overs: ". (int)($bowl_data[2]/6)."<br>");
                print("Wickets: ". ($bowl_data[4])."<br>");
                print("Average: ". ($bowl_data[6])."<br>");
                print("Economy: ". ($bowl_data[7])."<br>");
                print("4 Wickets: ". ($bowl_data[9])."<br>");
            }
            print($i. "\t". $node->text(). "<br>");
        });
        return new Response("Ram");
    }
}