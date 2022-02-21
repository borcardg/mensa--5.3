<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Label;
use App\Site;
use Carbon\Carbon;
use Dimsav\Translatable\Translatable;
use GuzzleHttp as Guzzle;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request as Input;
use PDF;
use View;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $sites = Site::all();

        return view('sites.index', compact('sites'));
    }

    public function form($action, $id)
    {
        if ($id != 0) {
            $labels = Label::all()->pluck('name', 'id');
            $site = Site::findOrFail($id);

            return view('sites.'.$action, compact('site', 'labels'));
        } else {
            return view('sites.'.$action);
        }
    }

    /**
     * Generate Word
     *
     * @return void
     */
    public function generatePdf($id, $date)
    {
        $site = Site::find($id);

        $today = null;

        if (! empty($date)) {
            $today = Carbon::createFromFormat('d.m.Y', $date);
        } else {
            $today = Carbon::today();
        }

        $tempDate = $today->copy()->startOfWeek();

        $from = $today->copy()->startOfWeek()->toDateString();
        $to = $today->copy()->endOfWeek()->toDateString();

        $days = array_fill(0, 5, []);
        $days[0]['name'] = 'LU';
        $days[1]['name'] = 'MA';
        $days[2]['name'] = 'ME';
        $days[3]['name'] = 'JE';
        $days[4]['name'] = 'VE';

        $site_labels = json_decode($site->export);

        array_walk($site_labels, function (&$item, $key) {
            $item = intval($item);
        });

        $weeklyMenus = Site::find($id)->menus()
            ->join('labels', 'labels.id', '=', 'menus.label_id')
            ->where('date_start', '<=', $to)
            ->where('date_end', '>=', $from)
            ->whereIn('label_id', $site_labels)
            ->orderBy('date_start')->orderBy('order', 'desc')
            ->select('menus.*')
            ->get();

        $weeklyNotices = Site::find($id)->notices()
            ->where('date_start', '<=', $to)
            ->where('date_end', '>=', $from)
            ->orderBy('date_start')->get();

        $from = $today->copy()->startOfWeek()->format('d.m.Y');
        $to = $today->copy()->endOfWeek()->format('d.m.Y');

        /* create weekly calendar */
        $menus = array_fill(0, 5, []);
        $notices = array_fill(0, 5, []);

        //loops through a week
        for ($i = 0; $i < 5; $i++) {
            $weeklyMenus->each(function ($item) use (&$tempDate, &$menus) {
                if ($item->date_start <= $tempDate->toDateString() && $item->date_end >= $tempDate->toDateString()) {
                    if ($tempDate->dayOfWeek == 0) {
                        $menus[$tempDate->dayOfWeek + 6][] = $item;
                    } else {
                        $menus[$tempDate->dayOfWeek - 1][] = $item;
                    }
                }
            });

            $weeklyNotices->each(function ($item) use (&$tempDate, &$notices) {
                if ($item->date_start <= $tempDate->toDateString() && $item->date_end >= $tempDate->toDateString()) {
                    if ($tempDate->dayOfWeek == 0) {
                        $notices[$tempDate->dayOfWeek + 6][] = $item;
                    } else {
                        $notices[$tempDate->dayOfWeek - 1][] = $item;
                    }
                }
            });

            $tempDate->addDay();
        }

        $labels = [];
        foreach ($site_labels as $slb) {
            $labels[] = Label::find($slb);
        }
        foreach ($days as $key => $day) {
            $days[$key]['notices'] = $notices[$key];
            $days[$key]['menus'] = [];
            foreach ($menus[$key] as $m) {
                $days[$key]['menus'][$m->label_id] = $m;
            }
        }

        $frArr = explode('.', $from);
        $toArr = explode('.', $to);

        $fr2 = $from;
        if ($frArr[2] == $toArr[2]) {
            $fr2 = $frArr[0].'.'.$frArr[1];
            // if($frArr[1] == $toArr[1]){
            //     $fr2 = $frArr[0];
            // }
        }
        $from = $today->copy()->startOfWeek()->format('d.m.Y');
        $to = $today->copy()->endOfWeek()->format('d.m.Y');

        $data = [
            'labels' => $labels,
            'days' => $days,
            'from' => $fr2,
            'to' => $to,
            'site' => $site,
        ];
        $pdf = PDF::loadView('pdf.export', $data);

        setlocale(LC_ALL, 'en_US.utf8');
        $sitename = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', str_replace(' ', '-', $site->name)));

        $name = 'menu_'.$sitename.'_week'.$today->weekOfYear;

        return $pdf->download($name.'.pdf');
        //   return $pdf->stream('document.pdf');
    }

    /**
     * Display a listing of the resource (menu) corresponding to the selected site and current week.
     *
     * @return Response
     */
    public function weekly(Request $request, $id, $date)
    {
        if ($request->has('sites')) {
            $id = $request->input('sites');
        }

        $site = Site::find($id);
        if ($site->isCafet) {
            return redirect()->route('sites.show', ['id' => $site->id]);
        }

        $today = Carbon::createFromFormat('d.m.Y', $date);
        if ($request->has('selected_date')) {
            $today = Carbon::createFromFormat('d.m.Y', $request->input('selected_date'));
        }

        $tempDate = $today->copy()->startOfWeek();

        $from = $today->copy()->startOfWeek()->toDateString();
        $to = $today->copy()->endOfWeek()->toDateString();

        $weeklyMenusAM = Site::find($id)->menus()
            ->join('labels', 'labels.id', '=', 'menus.label_id')
            ->where('date_start', '<=', $to)
            ->where('date_end', '>=', $from)
            ->where('period', 1)
            ->orderBy('date_start')->orderBy('order', 'desc')
            ->select('menus.*')
            ->get();
        $weeklyMenusPM = Site::find($id)->menus()
            ->join('labels', 'labels.id', '=', 'menus.label_id')
            ->where('date_start', '<=', $to)
            ->where('date_end', '>=', $from)
            ->where('period', 0)
            ->orderBy('date_start')->orderBy('order', 'desc')
            ->select('menus.*')
            ->get();
        $weeklyNotices = Site::find($id)->notices()
            ->where('date_start', '<=', $to)
            ->where('date_end', '>=', $from)
            ->orderBy('date_start')->get();

        $from = $today->copy()->startOfWeek()->format('d.m.Y');
        $to = $today->copy()->endOfWeek()->format('d.m.Y');

        /* create weekly calendar */
        $menusAM = array_fill(0, 7, []);
        $menusPM = array_fill(0, 7, []);
        $notices = array_fill(0, 7, []);

        //loops through a week
        for ($i = 0; $i < 7; $i++) {
            $weeklyMenusAM->each(function ($item) use (&$tempDate, &$menusAM) {
                if ($item->date_start <= $tempDate->toDateString() && $item->date_end >= $tempDate->toDateString()) {
                    if ($tempDate->dayOfWeek == 0) {
                        $menusAM[$tempDate->dayOfWeek + 6][] = $item;
                    } else {
                        $menusAM[$tempDate->dayOfWeek - 1][] = $item;
                    }
                }
            });

            $weeklyMenusPM->each(function ($item) use (&$tempDate, &$menusPM) {
                if ($item->date_start <= $tempDate->toDateString() && $item->date_end >= $tempDate->toDateString()) {
                    if ($tempDate->dayOfWeek == 0) {
                        $menusPM[$tempDate->dayOfWeek + 6][] = $item;
                    } else {
                        $menusPM[$tempDate->dayOfWeek - 1][] = $item;
                    }
                }
            });

            $weeklyNotices->each(function ($item) use (&$tempDate, &$notices) {
                if ($item->date_start <= $tempDate->toDateString() && $item->date_end >= $tempDate->toDateString()) {
                    if ($tempDate->dayOfWeek == 0) {
                        $notices[$tempDate->dayOfWeek + 6][] = $item;
                    } else {
                        $notices[$tempDate->dayOfWeek - 1][] = $item;
                    }
                }
            });

            $tempDate->addDay();
        }

        $sites = Site::where('isCafet', '=', '0')->get();

        $view = View::make('sites.weekly-menus-by-date', compact('site', 'menusAM', 'menusPM', 'notices', 'from', 'to', 'sites'));

        if ($request->ajax()) {
            $sections = $view->renderSections();

            return $sections['weekly-body'];
        }

        return view('sites.weekly-menus-by-date', compact('site', 'menusAM', 'menusPM', 'notices', 'from', 'to', 'sites'));
    }

    /**
     * Generate Word
     *
     * @return void
     */
    public function generateWord($id, $date)
    {
        $site = Site::find($id);

        $today = null;

        if (! empty($date)) {
            $today = Carbon::createFromFormat('d.m.Y', $date);
        } else {
            $today = Carbon::today();
        }

        $tempDate = $today->copy()->startOfWeek();

        $from = $today->copy()->startOfWeek()->toDateString();
        $to = $today->copy()->endOfWeek()->toDateString();

        $days = array_fill(0, 5, []);
        $days[0]['name'] = 'Lundi';
        $days[1]['name'] = 'Mardi';
        $days[2]['name'] = 'Mercredi';
        $days[3]['name'] = 'Jeudi';
        $days[4]['name'] = 'Vendredi';

        $site_labels = json_decode($site->export);

        array_walk($site_labels, function (&$item, $key) {
            $item = intval($item);
        });

        $weeklyMenus = Site::find($id)->menus()
            ->join('labels', 'labels.id', '=', 'menus.label_id')
            ->where('date_start', '<=', $to)
            ->where('date_end', '>=', $from)
            ->whereIn('label_id', $site_labels)
            ->orderBy('date_start')->orderBy('order', 'desc')
            ->select('menus.*')
            ->get();

        $weeklyNotices = Site::find($id)->notices()
            ->where('date_start', '<=', $to)
            ->where('date_end', '>=', $from)
            ->orderBy('date_start')->get();

        $from = $today->copy()->startOfWeek()->format('d.m.Y');
        $to = $today->copy()->endOfWeek()->format('d.m.Y');

        /* create weekly calendar */
        $menus = array_fill(0, 5, []);
        $notices = array_fill(0, 5, []);

        //loops through a week
        for ($i = 0; $i < 5; $i++) {
            $weeklyMenus->each(function ($item) use (&$tempDate, &$menus) {
                if ($item->date_start <= $tempDate->toDateString() && $item->date_end >= $tempDate->toDateString()) {
                    if ($tempDate->dayOfWeek == 0) {
                        $menus[$tempDate->dayOfWeek + 6][] = $item;
                    } else {
                        $menus[$tempDate->dayOfWeek - 1][] = $item;
                    }
                }
            });

            $weeklyNotices->each(function ($item) use (&$tempDate, &$notices) {
                if ($item->date_start <= $tempDate->toDateString() && $item->date_end >= $tempDate->toDateString()) {
                    if ($tempDate->dayOfWeek == 0) {
                        $notices[$tempDate->dayOfWeek + 6][] = $item;
                    } else {
                        $notices[$tempDate->dayOfWeek - 1][] = $item;
                    }
                }
            });

            $tempDate->addDay();
        }

        $labels = [];
        foreach ($site_labels as $slb) {
            $labels[] = Label::find($slb);
        }
        foreach ($days as $key => $day) {
            $days[$key]['notices'] = $notices[$key];
            $days[$key]['menus'] = [];
            foreach ($menus[$key] as $m) {
                $days[$key]['menus'][$m->label_id] = $m;
            }
        }

        // Creating the new document...
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        /* Note: any element you append to a document must reside inside of a Section. */

        // Adding an empty Section to the document...
        $section = $phpWord->addSection();
        // Adding Text element to the Section having font styled by default...

        $timeFrom = strtotime($from);
        $timeTo = strtotime($to);
        $menusText = '';
        setlocale(LC_TIME, 'fr_CH');
        if (date('F Y', $timeFrom) == date('F Y', $timeTo)) {
            $menusText = 'Menus du '.strftime('%e', $timeFrom).' au '.strftime('%e %B %Y', $timeTo);
        } else {
            $menusText = 'Menus du '.strftime('%e %B', $timeFrom).' au'.strftime('%e %B %Y', $timeTo);
        }

        $section->addText(
            $menusText, ['name' => 'Arial', 'size' => 18, 'bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]
        );
        $section->addTextBreak(1);
        $section->addText(
            $site->name, ['name' => 'Arial', 'size' => 14], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]
        );
        $section->addTextBreak(3);

        $width = 9000 / (count($labels));
        $labCount = count($labels);

        $cellHCentered = ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT];
        $fancyTableStyle = ['cellMarginTop' => 150, 'cellMarginBottom' => 150, 'cellMarginLeft' => 100, 'cellMarginRight' => 100];
        // $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'FFFF00');
        $cellRowContinue = ['vMerge' => 'continue'];
        // $cellColSpan = array('gridSpan' => $labCount, 'valign' => 'center');
        $cellVCentered = ['valign' => 'top'];
        $spanTableStyleName = 'Colspan Rowspan';
        $phpWord->addTableStyle($spanTableStyleName, $fancyTableStyle);
        $table = $section->addTable($spanTableStyleName);

        $table->addRow();
        $table->addCell(1000, $cellVCentered);
        foreach ($labels as $label) {
            $table->addCell($width, $cellVCentered)->addText($label->name.' (CHF '.$label->price.')', ['bold'=> true], $cellHCentered);
        }

        $odd = true;

        foreach ($days as $day) {
            $cellRowSpan = null;
            $cellVCentered = null;
            $cellColSpan = null;
            if ($odd) {
                $cellRowSpan = ['vMerge' => 'restart', 'valign' => 'top', 'bgColor' => 'F2F2F2'];
                $cellVCentered = ['valign' => 'top', 'bgColor' => 'F2F2F2'];
                $cellColSpan = ['gridSpan' => $labCount, 'valign' => 'top', 'bgColor' => 'F2F2F2'];
            } else {
                $cellRowSpan = ['vMerge' => 'restart', 'valign' => 'top', 'bgColor' => 'FFFFFF'];
                $cellVCentered = ['valign' => 'top', 'bgColor' => 'FFFFFF'];
                $cellColSpan = ['gridSpan' => $labCount, 'valign' => 'top', 'bgColor' => 'FFFFFF'];
            }
            $odd = ! $odd;

            $table->addRow();
            $cell1 = $table->addCell(1000, $cellRowSpan);
            $textrun1 = $cell1->addTextRun($cellHCentered);
            $textrun1->addText($day['name'], ['bold'=> true]);

            if (count($day['notices']) > 0) {
                $cell2 = $table->addCell(($labCount * $width), $cellColSpan);
                $textrun2 = $cell2->addTextRun($cellHCentered);
                $textNotices = '';
                foreach ($day['notices'] as $notice) {
                    $textrun2->addText($notice->title, ['italic'=>true]);
                    $textrun2->addTextBreak();
                    $textrun2->addText($notice->content, ['italic'=>true]);
                }
                $table->addRow();

                $table->addCell(null, $cellRowContinue);
                foreach ($labels as $label) {
                    if (isset($day['menus'][$label->id])) {
                        $cell = $table->addCell($width, $cellVCentered);
                        $cell->addText($day['menus'][$label->id]->title, ['bold'=> true], $cellHCentered);

                        $accomp = $day['menus'][$label->id]->accompaniment;
                        $acc = explode('<br />', $accomp);
                        foreach ($acc as $line) {
                            $cell->addText(trim($line), null, $cellHCentered);
                        }

                        // $cell->addText($day["menus"][$label->id]->accompaniment, null, $cellHCentered);
                    } else {
                        $table->addCell($width, $cellVCentered);
                    }
                }
            } else {
                foreach ($labels as $label) {
                    if (isset($day['menus'][$label->id])) {
                        $cell = $table->addCell($width, $cellVCentered);
                        $cell->addText($day['menus'][$label->id]->title, ['bold'=> true], $cellHCentered);

                        $accomp = $day['menus'][$label->id]->accompaniment;

                        $acc = explode('<br />', $accomp);

                        foreach ($acc as $line) {
                            $cell->addText(trim($line), null, $cellHCentered);
                        }
                    } else {
                        $table->addCell($width, $cellVCentered);
                    }
                }

                $table->addRow();
                $table->addCell(null, $cellRowContinue);
                foreach ($labels as $label) {
                    $table->addCell($width, $cellVCentered);
                }
            }
        }

        // \PhpOffice\PhpWord\Shared\Html::addHtml($section, $view);

        // Saving the document as OOXML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $filename = 'menus-de-la-semaine.docx';

        try {
            $objWriter->save(storage_path('app/'.$filename));
        } catch (Exception $e) {
        }

        $path = storage_path('app/'.$filename);
        $headers = [
            'Content-Type' => 'application/docx',
            'Content-Disposition' => 'inline; filename="'.$filename.'"',
        ];

        return response()->download($path, $filename, $headers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('sites.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = [
            'isCafet' => Input::get('isCafet'),
            'fr'  => Input::get('fr'), // returns an array ['name' => value]
            'de'  => Input::get('de'),
        ];
        Site::create($data);

        return redirect('home')->with('msg', 'Le site a bien été ajouté!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $site = Site::find($id);

        return view('sites.show', compact('site'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $site = Site::find($id);
        $labels = Label::all()->pluck('name', 'id');
        //return $labels;
        return view('sites.edit', compact('site', 'labels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $site = Site::findOrFail($id);

        $v = Input::get('isCafet');
        if (isset($v)) {
            $site->isCafet = Input::get('isCafet');
        } else {
            $site->isCafet = false;
        }
        $site->export = Input::get('export');
        $site->opentimenoon = Input::get('opentimenoon');
        $site->opentimeevening = Input::get('opentimeevening');
        //$export = Input::get('export');

        $site->translate('fr')->name = Input::get('name'); // get('en') returns an array ['name' => value]
        $site->translate('de')->name = Input::get('de')['name'];

        $site->translate('fr')->texte = Input::get('texte'); // get('en') returns an array ['name' => value]
        $site->translate('de')->texte = Input::get('de')['texte'];

        $site->translate('fr')->remark = Input::get('remark'); // get('en') returns an array ['name' => value]
        $site->translate('de')->remark = Input::get('de')['remark'];

        $site->translate('fr')->address = Input::get('address'); // get('en') returns an array ['name' => value]
        $site->translate('de')->address = Input::get('de')['address'];

        $site->save();

        return redirect('home')->with('msg', 'Le site a bien été enregistré!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $site = Site::findOrFail($id);

        $site->delete();

        return redirect('home')->with('msg', 'Le site a bien été supprimé!');
    }
}
