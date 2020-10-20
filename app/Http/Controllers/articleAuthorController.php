<?php

namespace App\Http\Controllers;

use App\Journal;
use App\Models\SubmissionAuthor;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class articleAuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = DB::table('article_authors')->get();
        return view('editor.articleAuthor.index', compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $authors = SubmissionAuthor::all();
        return view('editor.articleAuthor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request->all());
        $request->validate([
            'authorName' => 'required',
            // 'authorEmailAddress' => 'required',
            // 'authors_ids' => 'required',
            // 'volume' => 'required',
            // 'type' => 'required',
            // 'pdf' => 'required|mimes:pdf|max:40400'
        ]);

        // $chkDuplicate = DB::table('article_authors')
        //               ->where('email',$request['authorEmailAddress'])
        //               ->first();
               
        // if($chkDuplicate){
        //     return redirect()->route('editor.create-article-author')->with('error', 'This Author was created before!');
        // }

        $saveData = DB::table('article_authors')->insert([
            'name' => $request['authorName'],
            'email' => $request['authorEmailAddress'],
            'institution' => $request['authorInstitution']
        ]);

        if($saveData){
            return redirect()->route('editor.create-article-author')
            ->with('success', 'Author saved successfully.');
        }else{
            return redirect()->route('editor.create-article-author')
            ->with('error', 'Something went worng!');
        }

       
        // $journal = new Journal;
        // $journal->name = $request->name;

        // $journal_sname= str_replace(array("", "\"", "&quot;"), "", $journal->name );
        // $journal_name = htmlspecialchars(preg_replace('/\s+/', '-', $journal_sname));
       

        // $pdf = $request->file('pdf');
        // if (isset($pdf)) {
        //     $pdf_name = $journal_name . '-' . time() . '.' . $pdf->getClientOriginalExtension();
        //     $pdf->move(public_path() . '/journals/pdf/'.$request->volume.'/', $pdf_name);
        //     $journal->pdf = $pdf_name;
        // }

        // $journal->type = $request->type;
        // $journal->authors_ids = json_encode($request->authors_ids);
        // $journal->volume = $request->volume;
        // if ($journal->save()) {
        //     return redirect()->route('editor.create-journal')
        //         ->with('success', 'Journal saved successfully.');
        // } else {
        //     return redirect()->route('editor.create-journal')->with('error', 'Something went worng!');
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $journal = Journal::findOrFail($id);        
        $authors = SubmissionAuthor::all();
        return view('editor.journal.view', compact(['journal', 'authors']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $journal = Journal::findOrFail($id);    
        $authors = SubmissionAuthor::all();
        return view('editor.journal.edit', compact(['journal', 'authors']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'authors_ids' => 'required',
            'volume' => 'required',
            'type' => 'required'
        ]);
        // return $request->all();
        $journal = Journal::findOrFail($id); 
        $journal->name = $request->name;

        $journal_sname= str_replace(array("'", "\"", "&quot;"), "", $journal->name );
        $journal_name = htmlspecialchars(preg_replace('/\s+/', '-', $journal_sname));
        // dd($journal_name);

        $pdf = $request->file('pdf');
        if (isset($pdf)) {
            $pdf_name = $journal_name . '-' . time() . '.' . $pdf->getClientOriginalExtension();
            //for image unlink
            if(!empty($journal->pdf)) {
                if (file_exists(public_path('/journals/pdf/'.$request->volume.'/'. $journal->pdf))) {
                    unlink(public_path('/journals/pdf/'.$request->volume.'/'. $journal->pdf));
                }
            }
            $pdf->move(public_path() . '/journals/pdf/'.$request->volume.'/', $pdf_name);
            $journal->pdf = $pdf_name;
        }

        $journal->type = $request->type;
        $journal->authors_ids = json_encode($request->authors_ids);
        $journal->volume = $request->volume;
        if ($journal->update()) {
            return redirect()->route('editor.edit-journal', $id)
                ->with('success', 'Journal updated successfully.');
        } else {
            return redirect()->route('editor.edit-journal', $id)->with('error', 'Something went worng!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $journal = Journal::findOrFail($id);
        if(!empty($journal->pdf)) {
            if (file_exists(public_path('/journals/pdf/'.$journal->volume.'/'. $journal->pdf))) {
                unlink(public_path('/journals/pdf/'.$journal->volume.'/'. $journal->pdf));
            }
        }
        $journal->delete();

        return redirect()->route('editor.journals')->with('success', 'Journal rmoved successfully!');
    }
}
