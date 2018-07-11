<?php
/**
 * Created by Naieem Mahmud Supto.
 * Date: 7/10/2018
 * Time: 7:13 PM
 */

namespace App\Library\Services;

use App\Film;
use App\Comment;
use Illuminate\Http\Request;

class DBClasss
{
    /**
     * Title:updateFilm
     * Description: Updating film according to id
     * @param requested info,Id to be changed
     * @return
     */
    public function UpdateFilm(Request $request, $id){

        $newData =[
            "Name"=>$request->Name,
            "Description"=>$request->Description,
            "Rating"=>$request->Rating,
            "TicketPrice"=>$request->TicketPrice,
            "Country"=>$request->Country,
            "Genre"=>$request->Genre,
            "Photo"=>$request->Photo,
        ];
        $film = Film::where('id',$id)->update($newData);
        if($film){
            return response([
                "status"=>true,
                "message"=>"Film update succesfull"
            ],200);
        }
        return response($film,200);
    }

    public function getFilmById($id){
        return Film::with('comment')->where('id',$id)->get();
    }
    public function getBySqlFilter(Request $request){
        return Film::skip($request->skip)->take(1)->get();
    }
    public function getBySlug($slug){
        return Film::with('comment')->where('Slug',$slug)->get();
    }
    public function addComment($request){
        $comment = new Comment();
        $comment->Name = $request->Name;
        $comment->film_id = $request->film_id;
        $comment->Comment = $request->Comment;
        try{
            $isSaved = $comment->save();
            if($isSaved){
                return [
                    'status' => true,
                    'message' =>'Comment added succesfully'
                ];
            }
        }catch(\Illuminate\Database\QueryException $error){
            return [
                'status' => false,
                'message' =>$error->errorInfo[2]
            ];
        }
    }
    public function insertNewFilm($request){
        $film =  new Film();
        $film->Name = $request->Name;
        $film->Description = $request->Description;
        $film->Rating = $request->Rating;
        $film->RealeaseDate = $request->RealeaseDate;
        $film->TicketPrice = $request->TicketPrice;
        $film->Country = $request->Country;
        $film->Genre = $request->Genre;
        $film->Slug = $request->Slug;
        $film->Photo = $request->Photo;

        try{
            $isSaved = $film->save();
            if($isSaved){
                return [
                    'status' => true,
                    'message' =>'Film saved succesfully'
                ];
            }
        }catch(\Illuminate\Database\QueryException $error){
            return [
                'status' => false,
                'message' =>$error->errorInfo[2]
            ];
        }

    }
}