<?php

namespace App\Http\Controllers\API\V1;

use PDFParser;
use Carbon\Carbon;
use App\Models\Note;
use App\Models\User;
use App\Models\Board;
use App\Models\Member;
use App\Models\Meeting;
use App\Models\CanvasItem;
use App\Models\AudioNote;
use App\Models\Committee;
use Spatie\PdfToText\Pdf;
use App\Models\Notification;
use App\Models\Stroke;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Smalot\PdfParser\Parser; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SearchableRequest;
use Illuminate\Support\Facades\Validator;
use App\Services\FirebaseNotificationService;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Auth;

class NotesController extends Controller
{
    use HttpResponses;

    //  FirebaseNotificationService $firebaseNotificationService;
    public function __construct(private FirebaseNotificationService $firebaseNotificationService)
    {
        $this->firebaseNotificationService = $firebaseNotificationService;
    }

    public function removeExtraSpaces($text) {
        // Replace two or more spaces with a single space
        $cleanedText = preg_replace('/\s+/', ' ', $text);
        return $cleanedText;
    }

    public function stringToArray($inputString) {
        return explode(' ', $inputString);
    }

    public function processStringVaryingBehavior($inputString) {
        $results = [];
    
        // Original string
        $results[0] = $inputString;
    
        // Remove words shorter than 4 characters
        $words = explode(' ', $inputString);
        $filteredWords = array_filter($words, function($word) {
            return mb_strlen($word, 'UTF-8') >= 4;
        });
        $results[1] = implode(' ', $filteredWords);
    
        // Randomize word order
        shuffle($words);
        $results[2] = implode(' ', $words);
    
        return $results;
    }
    
    public function randomSubset($words) {
        shuffle($words); // Shuffle the array of words
        
        // Decide whether to return the whole array or just a part of it
        if (rand(0, 1) === 1) { // 50% chance
            // Return the whole shuffled array
            return $words;
        } else {
            // Return a subset of the array
            $subsetLength = rand(1, count($words)); // Determine the length of the subset
            return array_slice($words, 0, $subsetLength); // Return the subset
        }
    }

    public function searchArabicText($request)
    {
        $searchText = $this->removeExtraSpaces(trim($request->input('searchText')));
        // dd($searchText);
        \Log::info("coming request searchArabicText function");
    
        $files = $this->getPdfFiles();
        $results = [];
        foreach ($files['meetings'] as $file) {
            $text = Pdf::getText($file, 'C:\poppler\Library\bin\pdftotext.exe');
            
            // Get all modified versions of searchText
            $modifiedSearchTexts = $this->processStringVaryingBehavior($searchText);
           
            foreach ($modifiedSearchTexts as $i => $modifiedSearchText) {
                // echo 'modifiedSearchText '. $modifiedSearchText;
                if (!empty($modifiedSearchText)) {
                    $count = substr_count(strtolower($text), strtolower($modifiedSearchText));
                    if ($count || $count > 0) {
                        $results[] = [
                            'url' => $file,
                            'count' => $count,
                            'search_text' => $modifiedSearchText,
                            'modification_type' => $i // Indicate the type of modification
                        ];
                        // Do not break; collect all matches
                    }
                }
            }
            // if (!empty($results) || empty($results)) {
    
                      // Perform 5 shuffles and searches
                for ($i = 0; $i < 10; $i++) {
                    // Shuffle the search text
                    $words = $this->stringToArray($searchText);
                    // Use the randomSubset function to shuffle and potentially return a subset of words
                    $subsetWords = $this->randomSubset($words);
                    
                    $shuffledSearchText = implode(' ', $subsetWords);
                    // dd($words , $shuffledSearchText);
                    // Search with the shuffled text
                    $count = substr_count(strtolower($text), strtolower($shuffledSearchText));
                    if ($count > 0) {
                        $results[] = [
                            'url' => $file,
                            'count' => $count,
                            'search_text' => $shuffledSearchText,
                            'shuffle_iteration' => $i + 1 // Indicates the shuffle iteration (1 through 5)
                        ];
                        // Continue to next shuffle without breaking, to collect results from all shuffles
                    }
                    // echo 'hi '.$i;
                }
            // }
            //If no match was found with any modifications, proceed to search with individual words
            if (!empty($results) || empty($results)) {
                $words = $this->stringToArray($searchText);

                $filteredWords = array_filter($words, function($word) {
                    return mb_strlen($word, 'UTF-8') >= 4;
                });

                foreach ($filteredWords as $word) {
                    if (!empty($word)) { // Ensure the word is not empty
                        $count = substr_count(strtolower($text), strtolower($word));
                        if ($count > 0) {
                            $results[] = [
                                'url' => $file,
                                'count' => $count,
                                'search_text' => $word,
                                'modification_type' => 'word' // Indicate searching by individual word
                            ];
                            break; // Exit the loop early since a match was found
                        }
                    }
                    // echo 'word '.$word;
                }
            }

        }
    
        if (!empty($results)) {
            return $this->success(['files' => $results]);
        } else {
            return response()->json(['found' => false, 'message' => 'Text not found in any PDF.']);
        }
    }
    

    public function searchEnglishText($request)
    {
            \Log::info("comeing request searchEnglishText function");
            $searchText  = $request->input('searchText');
            $files = $this->getPdfFiles();
            $results = [];
            foreach ($files['meetings'] as $file) {
                $config = new \Smalot\PdfParser\Config();
                $config->setIgnoreEncryption(true);
                $parser = new \Smalot\PdfParser\Parser([], $config);
                 try {
                        $pdf = $parser->parseFile($file);
                        $text = $pdf->getText();
                        
                        if (false === mb_check_encoding($text, 'UTF-8')) {
                            // If the text is not valid UTF-8, continue to the next file
                            continue;
                        }
                        // dd($text);
                        // Count occurrences of the search term
                        $count = substr_count(strtolower($text), strtolower($searchText));
                        if ($count > 0) {
                            $results[] = [
                                'url' => $file,
                                'count' => $count,
                                'search_text' => $request->input('searchText')
                            ];
                        }
                    } catch (\Exception $e) {
                        // Handle any exceptions, possibly log them or continue to the next file
                        continue;
                    }
            }
    
            if (!empty($results)) {
                return $this->success(['files' =>  $results]); 
            } else {
                return response()->json(['found' => false, 'message' => 'Text not found in any PDF.']);
            }
         
    }
    

    public function makeSearchForAllFile(SearchableRequest $request) {
        \Log::info("comeing request makeSearchForAllFile function");
        // \Log::info($request->all());
        $arabicPattern = '/[\x{0600}-\x{06FF}\x{0750}-\x{077F}\x{08A0}-\x{08FF}\x{FB50}-\x{FDFF}\x{FE70}-\x{FEFF}]/u';
        // English regex pattern
        $englishPattern = '/[a-zA-Z]/';
        
        // Check for Arabic and English characters
        $containsArabic = preg_match($arabicPattern, $request->input('searchText'));
        $containsEnglish = preg_match($englishPattern, $request->input('searchText'));
        
        // Determine language
        if ($containsArabic && !$containsEnglish) {
            return $this->searchArabicText($request);
        } elseif (!$containsArabic && $containsEnglish) {
            return $this->searchArabicText($request);
        } elseif ($containsArabic && $containsEnglish) {
            return $this->searchArabicText($request);
        } else {
            return  $this->searchArabicText($request);
        }
    }

    public function getPdfFiles()
    {
        $rootFolders = ['meetings']; // Root level folders
        $allPdfFiles = [];

        foreach ($rootFolders as $folder) {
            $path = public_path($folder); // Get the full path
            $allPdfFiles[$folder] = $this->getPdfFilesRecursively($path);
        }

        return $allPdfFiles; // Contains all PDF files, including those in subfolders
    }

    private function getPdfFilesRecursively($path)
    {
        $allPdfFiles = [];
        $files = File::allFiles($path);

        foreach ($files as $file) {
            if ( $file->getExtension() === 'pdf'  && is_readable($file->getPathname()) ) {
                
                    $allPdfFiles[] = $file->getPathname();
                 
            }
        }

        return $allPdfFiles;
    }

 

    public function reverseWords($sentence) {
        // Split the sentence into words
        $words = explode(' ', $sentence);
        
        // Reverse each word and collect the results
        $reversedWords = array_map(function($word) {
            return $this->mb_strrev($word);
        }, $words);
        
        // Reassemble the sentence
        return implode(' ', $reversedWords);
    }
    
    public function mb_strrev($str) {
        $r = '';
        for ($i = mb_strlen($str, 'UTF-8') - 1; $i >= 0; $i--) {
            $r .= mb_substr($str, $i, 1, 'UTF-8');
        }
        return $r;
    }

    public function extractArabicTextFromMultiplePdfFilesFromUri($request)
    {
        try{
            \Log::info("comeing request extractArabicTextFromMultiplePdfFilesFromUri function");
            $reversedSentence = $this->reverseWords($request->input('searchText'));
            $searchText = escapeshellarg($reversedSentence); // The text to search for
            $pdfUrls =  [
                "https://diligov.com/public/charters/annual_reports/1/12.pdf",
                "https://diligov.com/public/charters/annual_reports/1/16.pdf",
            ]; //$request->input('pdfUrls'); // Assuming this is an array of URLs
            // Prepare URLs for the command line
            $urlsString = implode(' ', array_map('escapeshellarg', $pdfUrls));
            // Construct the command
            $command = "python C:\\wamp64\www\apiLaravelLogtah/searchable_newtwork.py $searchText $urlsString";
            // Execute the command and capture the output
            exec($command, $output, $returnVar);
            // Process and return the response
            if ($returnVar === 0) {
                return $this->success(['files' => json_decode($output[0])]);
            } else {
                return $this->error('', 'An error occurred while processing the PDFs. !!!', 500);
            }
        }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on get list of notes for boards !!!', 500);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response 
     */

     public function extractEnglishTextFromMultiplePdfFilesFromUri($request)
    {
        try{
            \Log::info("comeing request extractEnglishTextFromMultiplePdfFilesFromUri function");
            $searchText = escapeshellarg($request->input('searchText')); // The text to search for
            $pdfUrls =  [
                "https://diligov.com/public/charters/annual_reports/1/12.pdf",
                "https://diligov.com/public/charters/annual_reports/1/16.pdf",
            ];  //$request->input('pdfUrls'); //$this-> getPdfFiles()["meetings"];  
            // dd($pdfUrls);
            // Prepare URLs for the command line
            $urlsString = implode(' ', array_map('escapeshellarg', $pdfUrls));
            // Construct the command
            $command = "python C:\\wamp64\www\apiLaravelLogtah/searchable_newtwork.py $searchText $urlsString";
            // Execute the command and capture the output
            exec($command, $output, $returnVar);
            // Process and return the response
            if ($returnVar === 0) {
                return $this->success(['files' => json_decode($output[0])]);
            } else {
                return $this->error('', 'An error occurred while processing the PDFs. !!!', 500);
            }
        }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on get list of notes for boards !!!', 500);
        }
    }


    public function extractTextFromLocalPdfFiles(Request $request)
    {
        try{
                \Log::info("comeing request searchText");
                $pdfPaths =  $request->input('pdfPaths'); // Assuming you receive the PDF path as input
                $searchText = escapeshellarg($request->input('searchText')); // And the text to search for
                $command =  "python C:\\wamp64\www\apiLaravelLogtah/searching.py $searchText";
                foreach ($pdfPaths as $path) {
                    $command .= ' ' . escapeshellarg($path);
                }
                exec($command, $output, $returnVar);
                if ($returnVar === 0) {
                    return $this->success(['files' => $output]);
                } else {
                    return $this->error('', 'An error occurred while processing the PDFs. !!!', 500);
                }
            }catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
                return $this->error('', 'some thing occurs on get list of notes for boards !!!', 500);
            }
    }


    public function getListOfBoardNotes(Request $request)
    {
        try{
            \Log::info($request->all());
            $currentYear = Carbon::now()->format('Y');
            $year = $request->dateYearRequest ?? $currentYear;
            \Log::info($year);
            $boards =  Board::with([
                                    'meetings' => function ($q) use($request){
                                            $q->with(['agendas' => function($q) use($request){ 
                                                $q->with([
                                                            'notes'=> function($query) use($request){
                                                                    if ($request->isChecked === true) {
                                                                        $query->byAuth(Auth::id())->with('user')->get();
                                                                    }else{
                                                                        $query->with('user');
                                                                    }
                                                            
                                                            }
                                                            ,
                                                            'audio_notes' => function($query) use($request){ 
                                                               if ($request->isChecked === true) {
                                                                        $query->byAuth(Auth::id())->with('user')->get();
                                                                    }else{
                                                                        $query->with('user');
                                                                    }
                                                                
                                                            }
                                                            ,
                                                            'strokes' => function($query) use($request){ 
                                                               if ($request->isChecked === true) {
                                                                        $query->byAuth(Auth::id())->with('user')->get();
                                                                    }else{
                                                                        $query->with('user');
                                                                }
                                                            }
                                                            ,
                                                            'canvasItems' => function($query) use($request){ 
                                                                $query->with('strokes');
                                                               if ($request->isChecked === true) {
                                                                        $query->byAuth(Auth::id())->with('user')->get();
                                                                    }else{
                                                                        $query->with('user');
                                                                }
                                                            }
                                                        ]);
                                                
                                            }])
                                            ->whereHas('agendas');
                                    },
                                    'business',
                                    'members' => function($e){
                                        return $e->with('position');
                                    }
                                    ]
                                    
                                    ) ->whereHas('meetings.agendas')
                            ->whereYear('created_at', $year)
                        ->get();
            if (!$boards) { return $this->error('', 'there\'s not notes for boards found ', 401); }
            return $this->success([
                'boards' => $boards,
            ]);
        
        }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on get list of notes for boards !!!', 500);
        }
    }


        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListOfCommitteeNotes(Request $request)
    {
        try{
            \Log::info("comeing request notes");
            $currentYear = Carbon::now()->format('Y');
            $year = $request->dateYearRequest ?? $currentYear;
            \Log::info($year);
            $committees =  Committee::with([
                                    'meetings' => function ($q) use($request){
                                            $q->with(['agendas' => function($q) use($request){ 
                                                $q->with([
                                                            'notes'=> function($query) use($request){
                                                                    if ($request->isChecked === true) {
                                                                        $query->byAuth(Auth::id())->with('user')->get();
                                                                    }else{
                                                                        $query->with('user');
                                                                    }
                                                            }
                                                            ,
                                                            'audio_notes' => function($query) use($request){ 
                                                               if ($request->isChecked === true) {
                                                                        $query->byAuth(Auth::id())->with('user')->get();
                                                                    }else{
                                                                        $query->with('user');
                                                                }
                                                                
                                                            }
                                                            ,
                                                            'strokes' => function($query) use($request){ 
                                                               if ($request->isChecked === true) {
                                                                        $query->byAuth(Auth::id())->with('user')->get();
                                                                    }else{
                                                                        $query->with('user');
                                                                }
                                                            }
                                                            ,
                                                            'canvasItems' => function($query) use($request){ 
                                                               if ($request->isChecked === true) {
                                                                        $query->byAuth(Auth::id())->with('user')->get();
                                                                    }else{
                                                                        $query->with('user');
                                                                }
                                                            }
                                                        ]);
                                                
                                            }])
                                            ->whereHas('agendas');
                                    },
                                    'business',
                                    'members' => function($e){
                                        return $e->with('position');
                                    }
                                    ]
                                    
                                    ) ->whereHas('meetings.agendas')
                            ->whereYear('created_at', $year)
                        ->get();
            if (!$committees) { return $this->error('', 'there\'s not notes for committees found ', 401); }
            return $this->success([
                'committees' => $committees,
            ]);
        
        }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on get list of notes for committees !!!', 500);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function insertNewNote(Request $request)
    {
        \Log::info($request->all());
        // try{
                $validator = Validator::make($request->all(),
                                        [
                                        // '*.ListDataOfNotes.*.criteria_category' => 'required',
                                            // "member_id" => 'required',
                                            "business_id" => 'required',
                                        ]);
        
                if ($validator->fails()) {
                    return  $this->error('', $validator->errors(), 401);
                }
                           
                // $signatureName = 'member_signature_'.time().'_.png';
                // $signatureSelf = base64_decode($request->uploadSignature);
                // Storage::disk('signatures_uploads')->put($signatureName, $signatureSelf);
                
                // $file = $request->member_profile_image;
                // $imageName = time() . '.' . $file;
                // $imageSelf = base64_decode($request->imageSelf);
                // Storage::disk('public_uploads')->put($request->business_id . '/' . $imageName, $imageSelf);
                $note = new Note;
                // if($request->List_data_of_notes && is_array($request->List_data_of_notes) && count($request->List_data_of_notes) > 0){
                //     for($i = 0; $i < count($request->List_data_of_notes); $i++){
                        
                //         $note->note = $request->List_data_of_notes[$i]['text'];
                //         $note->annotation_id = $request->List_data_of_notes[$i]['id'];
                //         $note->positionDx = $request->List_data_of_notes[$i]['positionDx'];
                //         $note->positionDy = $request->List_data_of_notes[$i]['positionDy'];
                //         $note->isPrivate = $request->List_data_of_notes[$i]['isPrivate'];
                //         $note->page_index = $request->List_data_of_notes[$i]['pageIndex'];
                //         $note->addby = $request->add_by;
                //         $note->agenda_id = $request->agenda_id;
                //         $note->business_id = $request->business_id;
                //         $note->file_edited = $request->file_edited;
                //         $note->save();
                //     }
                // }
                
                foreach ($request->List_data_of_notes as $noteRequest) {
                    $note = new Note;
                    $note->note = $noteRequest['text'];
                    $note->annotation_id = $noteRequest['id'];
                    $note->positionDx = $noteRequest['positionDx'];
                    $note->positionDy = $noteRequest['positionDy'];
                    $note->isPrivate = $noteRequest['isPrivate'];
                    $note->page_index = $noteRequest['pageIndex'];
                    $note->addby = $request->add_by;
                    $note->agenda_id = $request->agenda_id;
                    $note->business_id = $request->business_id;
                    $note->file_edited = $request->file_edited;
                    $note->save();
                }
                // Associate a note with a members
                if (!empty($request->shared_note_members)) {
                    $note->members()->attach($request->shared_note_members);
                    $members = User::whereIn('member_id', $request->shared_note_members)->get();
                    foreach ($members as $member) {
                        $data['token'] = $member->fcm;
                        $data['body'] = $note->note;
                        $data['title'] = 'mentioned you with new note';
                        $this->firebaseNotificationService->sendFirebaseNotification($data);

                        // Notification::create([
                        //     'notification_title' => $action->tasks,
                        //     'notification_body' => $action->date_due,
                        //     'notification_token' => $data['token'],
                        //     'member_id' => $member->id,
                        //     'user_id' => $request->add_by,
                        //     'note_id' => $note->id,
                        //     'action_id' => $action->id,
                        //     'business_id' => $request->business_id
                        // ]);
                    }
                }
                
                    if(!empty($request->records_files)){
                    $base64EncodedFiles = $request->records_files;
                    foreach ($base64EncodedFiles as $base64EncodedFile) {
                        $fileName ='record'.md5(uniqid(rand(), true)).'.mp3';
                        $fileData = base64_decode($base64EncodedFile['base64']);
                        Storage::disk('record_notes_uploads')->put($request->business_id . '/notes/records/' . $fileName, $fileData);
                    
                        $audioNote = AudioNote::create([
                            'audio_name' => $base64EncodedFile['fileName'],
                            'audio_random_name' => $fileName,
                            'audio_id' => $base64EncodedFile['id'],
                            'file_full_path' => '',
                            'audio_time' => '',
                            'positionDx' => '',
                            'positionDy' => '',
                            'page_index' => $base64EncodedFile['filePageIndex'],
                            'addby' => $request->add_by,
                            'agenda_id' => $request->agenda_id,
                            'business_id' => $request->business_id,
                        ]);
                    }
                }
                
                foreach ($request->canvas as $canvasItemData) {
                    // Create CanvasItem
                    $canvasItem = CanvasItem::create([
                        'canva_id' => $canvasItemData['canva_id'],
                        'position_dx' => $canvasItemData['position_dx'],
                        'position_dy' => $canvasItemData['position_dy'],
                        'canvas_width' => $canvasItemData['canvas_width'],
                        'canvas_height' => $canvasItemData['canvas_height'],
                        'page_index' => $canvasItemData['page_index'],
                        'addby' => $request->add_by,
                        'agenda_id' => $request->agenda_id,
                    ]);
                
                    // Loop through each Stroke for the current CanvasItem
                    foreach ($canvasItemData['strokes'] as $strokeData) {
                        
                        $position = array();
                        $position['dx'] =  $strokeData['position']['dx'];
                        $position['dy'] =  $strokeData['position']['dy'];
                      
                        $paints = array(); 
                        foreach ($strokeData['points'] as $pointData) {
                            $paints[] = [
                                'dx' => $pointData['dx'],
                                'dy' => $pointData['dy'],
                            ];
                        }  
                
                        $stroke = new Stroke([
                            'points' => json_encode($paints),
                            'position' => json_encode($position),
                            'page_index' => $strokeData['page_index'],
                            'stroke_color' => $strokeData['stroke_color'],
                            'stroke_width' => $strokeData['stroke_width'],
                            'stroke_cap' => $strokeData['stroke_cap'],
                            'canvas_item_id' => $canvasItemData['canva_id'],
                            'file_full_path' => $request->file_edited,
                            'addby' => $request->add_by,
                            'agenda_id' => $request->agenda_id,
                            'business_id' => $request->business_id,
                        ]);
                
                        // Associate the Stroke with the CanvasItem
                        $canvasItem->strokes()->save($stroke);
                    }
                }
                
                \Log::info($note);
                return $this->success([
                    'note' => $note,
                ]);
        // }catch (\Exception $e) {
        //     \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
        //     return $this->error('', 'some thing occurs on create note !!!', 500);
        // }
       
    }

    /**
     * get a list of notes resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getListOfNotes(Request $request)
    {
        \Log::info($request->all());
        try{
                $notes = Note::get();
                \Log::info($notes);
                return $this->success([
                    'notes' => $notes,
                ]);
            }catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
                return $this->error('', 'some thing occurs on get list notes !!!', 500);
            }
    }

 
 
}
