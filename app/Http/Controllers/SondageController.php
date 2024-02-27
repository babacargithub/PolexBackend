<?php

namespace App\Http\Controllers;

use App\Models\Parrainage;
use App\Models\QuestionSondage;
use App\Models\Reponse;
use App\Models\ReponseSondage;
use App\Models\Sondage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SondageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index()
    {
        //
        return Sondage::all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        //
        $sondage = new Sondage($request->validate([
            "titre"=>"required|unique:sondages",
            "description"=>"required",
            "questions"=>"required|array|min:1",
            "questions.*.libelle"=>"required",
            "questions.*.multiple"=>"required|boolean",
            'questions.*.reponsesAutorisees' => 'required|array|min:1',
        ],[
            "questions.*.reponsesAutorisees.required"=>"Chaque question doit avoir au moins une réponse",
            "titre.unique"=>"Un sondage avec ce meme titre existe déjà. Veuillez en choisir un autre."
        ]));



        DB::transaction(function () use ($sondage, $request){
            // Create Sondage
            $sondage->save();
//            $sondage->questions()->saveMany( collect($request->questions)->map(function($item){
//                $question = new QuestionSondage($item);
//                $question->reponsesAutorisees()->createMany($question['reponsesAutorisees']);
//            }));

            // Sample data for questions and their responses
            $questionsData = $request->questions;

            // Iterate through each question
            foreach ($questionsData as $questionData) {
                $reponsesData = $questionData['reponsesAutorisees'];
                unset($questionData['reponses']); // Remove responses from the question data

                // Save QuestionSondage
                $questionSondage = $sondage->questions()->create($questionData);

                // Save Reponses for the current QuestionSondage
                foreach ($reponsesData as $reponseData) {
                    $questionSondage->reponsesAutorisees()->create(["nom" => $reponseData]);
                }
            }
        });

        return response($sondage, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Sondage $sondage
     * @return Sondage
     */
    public function show(Sondage $sondage)
    {
        //
        return $sondage;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Sondage $sondage
     * @return Sondage
     */
    public function update(Request $request, Sondage $sondage)
    {
        //
         $sondage->update($request->validate([
             "titre"=>"unique:sondages,titre,".$sondage->id,
             "description"=>"string",
             "questions"=>"array|min:1",
             "questions.*.libelle"=>"string",
             "questions.*.multiple"=>"boolean",
             'questions.*.reponsesAutorisees' => 'array|min:1',
         ],[
             "questions.*.reponsesAutorisees.required"=>"Chaque question doit avoir au moins une réponse",
             "titre.unique"=>"Un sondage avec ce meme titre existe déjà. Veuillez en choisir un autre."
         ]));
         return $sondage;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Sondage $sondage
     * @return Response
     */
    public function destroy(Sondage $sondage)
    {
        //
        $sondage->delete();
        return response(null,204);
    }

    // ================================== QUESTIONS  ==================================
    public function questions(Sondage $sondage){
        $sondage->load('questions.reponsesAutorisees');
        return $sondage;
    }
    public function ajouterQuestion(Sondage $sondage, Request $request){

       $request->validate([
            "questions"=>"required|array|min:1",
            "questions.*.libelle"=>"required|string|unique:question_sondages,libelle,sondage_id",
            "questions.*.multiple"=>"required|boolean",
            'questions.*.reponsesAutorisees' => 'required|array|min:1'
        ],[
            "reponsesAutorisees.required"=>"Chaque question doit avoir au moins une réponse",
            "questions.*.libelle.unique"=>"Une question avec ce libellé existe déjà pour ce sondage"
        ])["questions"];

        $questionsData = $request->questions;

        // Iterate through each question
        foreach ($questionsData as $questionData) {
            $reponsesData = $questionData['reponsesAutorisees'];
            unset($questionData['reponses']); // Remove responses from the question data

            // Save QuestionSondage
            $questionSondage = $sondage->questions()->create($questionData);

            // Save Reponses for the current QuestionSondage
            foreach ($reponsesData as $reponseData) {
                $questionSondage->reponsesAutorisees()->create(["nom" => $reponseData]);
            }
        }
        return response($sondage, 201);
    }
    public function modifierQuestion(Sondage $sondage, QuestionSondage $question, Request $request){
        $question->update($request->validate([
            "libelle"=>"string",
            "multiple"=>"boolean"
        ]));
        return $question;
    }
    public function modifierReponseAutorisee(Reponse $reponse, Request $request){
        $reponse->update($request->validate([
            "nom"=>"string|unique:reponses,nom,question_sondage_id.".$reponse->question_sondage_id,
        ]));
        return $reponse;
    }
    public function supprimerQuestion(QuestionSondage $question){
        $question->delete();
        return response(null, 204);
    }public function supprimerReponse(Reponse $reponse){
        $reponse->delete();
        return response(null, 204);
    }
    // ================================== REPONSES  ==================================
    public function reponses(Sondage $sondage){
        $sondage->load('reponses');
        return $sondage->reponses;
    }
    public function ajouterReponseAUneQuestion(QuestionSondage $question, Request $request){

         $question->reponsesAutorisees()->createMany($request->validate([
            "reponses.*.nom"=>"required|string|unique:reponses,nom,question_sondage_id.".$question->id,
        ],["reponses.*.nom.unique"=>'Une meme réponse est déjà enregistrée !'])['reponses']);

         return $question;

    }
    public function saveResponse(Sondage $sondage, Request $request)
    {
         $requestBody = $request->validate([
             "reponses" => "required|array|min:1",
            "reponses.*.reponse_id" => "required|integer|exists:reponses,id",
            "reponses.*.reference"=>"string|unique:reponse_sondages,reference,question_sondage_id,reponse_id",
            'reponses.*.question_sondage_id' => 'required|integer|exists:question_sondages,id'],
            [
                "reponses.*.reference.unique"=>"Il semble que vous avez déjà répondu à cette question"
            ]);
         $insertedSuccess = ReponseSondage::insert($requestBody['reponses']);
        if($insertedSuccess){
            return response(null, 201);
        }else{
            return response(null, 500);
        }
    }

    // ================================== RESULTATS  ==================================
    public function resultats(Sondage $sondage){
        $questions = $sondage->questions;
        $reponses =[];
        foreach ($questions as $question) {
            $reponses[$question->libelle] = DB::select("SELECT reponses.nom, COUNT(reponse_sondages.reponse_id) as nombre FROM reponse_sondages JOIN reponses ON reponse_sondages.reponse_id = reponses.id WHERE reponse_sondages.question_sondage_id = ? GROUP BY reponses.nom ORDER BY nombre DESC", [$question->id]);
        }

       return ["sondage"=>$sondage, "reponses"=>$reponses];
    }


}
