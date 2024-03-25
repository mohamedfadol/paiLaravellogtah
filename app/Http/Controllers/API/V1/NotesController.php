<?php

namespace App\Http\Controllers\API\V1;

use Carbon\Carbon;
use App\Models\Note;
use App\Models\Board;
use App\Models\Meeting;
use App\Models\Committee;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SearchableRequest;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Process\Exception\ProcessFailedException;
use PDFParser;
use Smalot\PdfParser\Parser; 
class NotesController extends Controller
{
    use HttpResponses;

    public function searchArabicText($request)
    {
            \Log::info("comeing request searchArabicText function");
            $searchText  = $this->reverseWords($request->input('searchText'));
            // $folderPath = public_path('meetings/boards');
            // $files = \File::files($folderPath);
            $files = $this->getPdfFiles();
            // dd($files);
            $results = [];
            foreach ($files['meetings'] as $file) {
                $config = new \Smalot\PdfParser\Config();
                // Whether to retain raw image data as content or discard it to save memory
                // $config->setRetainImageContent(false);
                // Memory limit to use when de-compressing files, in bytes
                // $config->setDecodeMemoryLimit(100000000000000032);
                $config->setIgnoreEncryption(true);
                // $config->setHorizontalOffset('');
                // A tab can help preserve the structure of your document
                // $config->setHorizontalOffset("\t");
                // $config->setFontSpaceLimit(-60);
                $parser = new \Smalot\PdfParser\Parser([], $config);
                try{
                    $pdf = $parser->parseFile($file);
                    $text = $pdf->getText();
                    // Count occurrences of the search term
                    $count = substr_count(strtolower($text), $searchText);
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

    public function searchEnglishText($request)
    {
            \Log::info("comeing request searchEnglishText function");
            // echo 'pcre.backtrack_limit: ', ini_get('pcre.backtrack_limit'), '<br>';
            // echo 'pcre.recursion_limit: ', ini_get('pcre.recursion_limit'), '<br>';
            $searchText  = $request->input('searchText');
            // $files = $request->file('pdfs');
            $files = $this->getPdfFiles();
            // $files = \File::files($folderPath);
            // dd($files);
            $results = [];
            foreach ($files['meetings'] as $file) {
                $config = new \Smalot\PdfParser\Config();
                // Whether to retain raw image data as content or discard it to save memory
                // $config->setRetainImageContent(false);
                // Memory limit to use when de-compressing files, in bytes
                // $config->setDecodeMemoryLimit(100000000000000032);
                $config->setIgnoreEncryption(true);
                // $config->setHorizontalOffset('');
                // A tab can help preserve the structure of your document
                // $config->setHorizontalOffset("\t");
                // $config->setFontSpaceLimit(-60);
                $parser = new \Smalot\PdfParser\Parser([], $config);
                 try {
                        $pdf = $parser->parseFile($file);
                        $text = $pdf->getText();
                        // $testBinary = preg_replace('/\(.*$/s', '', $text);
                        // if (!preg_match('/^[a-zA-Z0-9 \r\n\/*#<>\[\].\'"_-]*$/', $testBinary)) {
                        //     // if (false === mb_check_encoding(preg_replace('/\(.*$/s', '', $text), 'UTF-8')) {
                        //     continue;
                        // }
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
            return $this->searchEnglishText($request);
        } elseif ($containsArabic && $containsEnglish) {
            return $this->searchEnglishText($request);
        } else {
            return  $this->searchEnglishText($request);
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
            \Log::info("comeing request notes");
            $currentYear = Carbon::now()->format('Y');
            $year = $request->dateYearRequest ?? $currentYear;
            \Log::info($year);
            $boards =  Board::with([
                                    'meetings' => function ($q) {
                                            $q->with('agendas')
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
                                    'meetings' => function ($q) {
                                            $q->with('agendas')
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
        try{
                $validator = Validator::make($request->all(),
                                        [
                                        // '*.ListDataOfNotes.*.criteria_category' => 'required',
                                            // "member_id" => 'required',
                                            "businessId" => 'required',
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
                
                if($request->ListDataOfNotes && is_array($request->ListDataOfNotes) && count($request->ListDataOfNotes) > 0){
                    for($i = 0; $i < count($request->ListDataOfNotes); $i++){
                        $note = new Note;
                        $note->note = $request->ListDataOfNotes[$i]['text'];
                        $note->annotation_id = $request->ListDataOfNotes[$i]['id'];
                        $note->positionDx = $request->ListDataOfNotes[$i]['positionDx'];
                        $note->positionDy = $request->ListDataOfNotes[$i]['positionDy'];
                        $note->isPrivate = $request->ListDataOfNotes[$i]['isPrivate'];
                        $note->page_index = $request->ListDataOfNotes[$i]['pageIndex'];
                        $note->addby = $request->addby;
                        $note->agenda_id = $request->agenda_id;
                        $note->business_id = $request->businessId;
                        $note->file_edited = $request->fileEdited;
                        $note->save();
                    }
                }
                
                \Log::info($note);
                return $this->success([
                    'note' => $note,
                ]);
        }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on create note !!!', 500);
        }
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
