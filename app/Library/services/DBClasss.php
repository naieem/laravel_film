<?php
/**
 * Created by Naieem Mahmud Supto.
 * Date: 7/10/2018
 * Time: 7:13 PM
 */

namespace App\Library\Services;

use App\Film;
use App\Comment;
use App\Genre;
use Illuminate\Http\Request;
use Validator;

class DBClasss
{
    /**
     * Update film by id
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function UpdateFilm(Request $request, $id)
    {

        $newData = [
            "Name" => $request->Name,
            "Description" => $request->Description,
            "Rating" => $request->Rating,
            "TicketPrice" => $request->TicketPrice,
            "Country" => $request->Country,
            "Genre" => $request->Genre,
            "Photo" => $request->Photo,
        ];
        $film = Film::where('id', $id)->update($newData);
        if ($film) {
            return response([
                "status" => true,
                "message" => "Film update succesfull"
            ], 200);
        }
        return response($film, 200);
    }

    /**
     * Get film by id
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getFilmById($id)
    {
        return Film::with(['Comment', 'Genre'])->where('id', $id)->get();
    }

    /**
     * Get single film by skip and take method
     * @param Request $request
     * @return mixed
     */
    public function getBySqlFilter(Request $request)
    {
        return Film::skip($request->skip)->take(1)->get();
    }

    /**
     * Get film by slug
     * @param $slug
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getBySlug($slug)
    {
        return Film::with(['Comment', 'Genre'])->where('Slug', $slug)->get();
    }

    /**
     * Adding new comment to film
     * @param $request
     * @return array
     */
    public function addComment($request)
    {
        $comment = new Comment();
        $comment->Name = $request->Name;
        $comment->film_id = $request->film_id;
        $comment->Comment = $request->Comment;
        try {
            $isSaved = $comment->save();
            if ($isSaved) {
                return [
                    'status' => true,
                    'message' => 'Comment added succesfully'
                ];
            }
        } catch (\Illuminate\Database\QueryException $error) {
            return [
                'status' => false,
                'message' => $error->errorInfo[2]
            ];
        }
    }

    /**
     * Inserting new film
     * @param $request
     * @return array
     */
    public function insertNewFilm($request)
    {
        $film = new Film();
        $validator = Validator::make($request->all(),
            [
                'Name' => 'required|string|max:255',
                'Description' => 'required|string',
                'Rating' => 'required|numeric|between:1,5',
                'TicketPrice' => 'required|string|max:255',
                'Country' => 'required|string',
                'Genre' => 'required',
                'Slug' => 'required|string',
                'Photo' => 'required|url',
                'RealeaseDate' => 'required|date'
            ],
            [
                "url" => "Photo url is not valid"
            ]);
        if ($validator->fails()) {
            return $validator->messages()->first();
        } else {
            $film->Name = $request->Name;
            $film->Description = $request->Description;
            $film->Rating = $request->Rating;
            $film->RealeaseDate = $request->RealeaseDate;
            $film->TicketPrice = $request->TicketPrice;
            $film->Country = $request->Country;
            $film->Slug = $request->Slug;
            $film->Photo = $request->Photo;
            // create genre array for inserting
            $genreList = $this->createGenreArray($request->Genre);
            // creating genre array for inserting done
            try {
                $isSaved = $film->save();
                if ($isSaved) {
                    // if there is genre to save
                    if (isset($genreList) && count($genreList) > 0) {
                        if ($film->comment()->saveMany($genreList)) {
                            return [
                                'status' => true,
                                'message' => 'Film saved succesfully'
                            ];
                        }
                    } // if there is no genre to save
                    else {
                        return [
                            'status' => true,
                            'message' => $genreList
                        ];
                    }
                }
            } catch (\Illuminate\Database\QueryException $error) {
                return [
                    'status' => false,
                    'message' => $error->errorInfo[2]
                ];
            }
        }


    }

    /**
     * Creating genre array for saving in db
     * @param $genreArray
     * @return array
     */
    protected function createGenreArray($genreArray)
    {
        $genreList = [];
        foreach ($genreArray as $value) {
            foreach ($value as $key => $genreTitle) {
                array_push($genreList,
                    new Genre([
                        "title" => $genreTitle
                    ]));
            }

        }
        return $genreList;
    }
}