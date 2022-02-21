<h2 style="margin-bottom:0px;font-family:FreeSans" class="center">Menus du {{ $from }} - {{ $to }}</h2>
<h3 style="margin-top:0px; padding-bottom:1em;font-family:FreeSans" class="center">{{ $site->name }}</h3>
<table>

<!-- <tr>
    <td class="title noBorder day"></td>
    <td class=" noBorder tt" colspan="2">MIDI</td>
    <td class=" noBorder tt">SOIR</td>
</tr> -->
<tr>
<td class="day border_right"></td>
    @foreach($labels as $label)
        <td  class="border{{ $label->id}}">{{ $label->name }} (CHF {{$label->price}})</td>
    @endforeach
</tr>

@foreach($days as $day)

<tr>

   @if(count($day["notices"])>0)
        <td rowspan="2" width="10%" class="day">{{ $day["name"] }}</td>
    @else
        <td width="10%" class="day day_height">{{ $day["name"] }}</td>
    @endif

    @if(count($day["menus"]))

        @foreach($labels as $label)
            <td class="bg{{ $label->id }}" width="{{ 90 / count($labels) }}%" valign="top">
                @if(isset($day["menus"][$label->id]))
                <p class="title">

                    @if($day["menus"][$label->id]->specialprice !== "")
                        <small>CHF {{ $day["menus"][$label->id]->specialprice }}</small><br>
                    @endif

                    @if($day["menus"][$label->id]->veg == "Menu végétarien")
                        <img style="float:left" src="{{asset('img/veg.png')}}" height="1em">
                    @endif

                    {{ $day["menus"][$label->id]->title }}
                    <br>
                    <span class="subtitle">
                        {{ $day["menus"][$label->id]->subtitle }}
                    </span>
                </p>
                <span class="separator">&nbsp;</span>

                <p class="smaller">
                    {!! $day["menus"][$label->id]->accompaniment !!}
                    @if($day["menus"][$label->id]->veg !== "" && $day["menus"][$label->id]->veg !== "Menu végétarien")
                        <br><br>
                        <img style="float:left" src="{{asset('img/veg.png')}}" height="1em">
                        <strong>{{ $day["menus"][$label->id]->veg }}</strong>
                    @endif
                @endif
                </p>
            </td>
        @endforeach

    @endif

    @if(count($day["notices"])>0)

    </tr>
        <tr>
    <td colspan="{{ count($labels) }}"><p class="smaller">
        @foreach($day["notices"] as $notice)
        <strong>{{$notice->title}}</strong>
        {{$notice->content}}
        @endforeach
    </p></td>

    @endif

</tr>
@endforeach

</table>

@if($site->remark!="")
<!-- Durant l'hiver, la mensa propose la fondue du lundi au jeudi de 17h30 - 19h00. Aucune réservation n'est nécessaire. Minimum 2 personnes, Fr. 12.-- par personne.  -->
<br>
<table>
    <tr>
        <td style="border:1px solid black">{{ $site->remark }}</td>
    </tr>
</table>
@endif

<br>

    <table class="info">
        <tr>
            <td style="text-align:left; width:73.5%">
                <p class="smaller" style="text-align:left!important">
                    <img src="https://static.thenounproject.com/png/31631-200.png" height="1.2em"> <strong>Tous nos repas sont servis avec potage</strong>
                    <br>
                    <img src="{{asset('img/veg.png')}}" height="1.2em" width="1.2em"> Le plat principal peut être remplacé par le plat végétarien
                    <br>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f3/Flag_of_Switzerland.svg/21px-Flag_of_Switzerland.svg.png" height="1.2em">
                    La provenance des viandes est Suisse si non precisée.
                </p>
            </td>
            <td style="text-align:left">
                <p class="smaller">
                    Horaires:<br>
                    @if($site->opentimenoon !== '')
                    Midi: {{ $site->opentimenoon }}<br>
                    @endif

                    @if($site->opentimeevening !== '')
                    Soir: {{ $site->opentimeevening }}<br>
                    @endif

                </p>
            </td>
        </tr>
    </table>


<p class="title center">{{ $site->texte }}</p>






<style>
td{
    font-family:"FreeSans";
}

.info td{
    border:0px;
}

.day_height{
    height:120px;
}
 body {
	font-family: 'opensans', sans-serif;
}
.day{
    border-left:0px;
}
.tt{
    /* background-color:#f4f4f4; */
    color:black;
    /* border-top:2px solid black; */
}
/* .border1{
    border-right:0px;
}
.border2{
    border-left:0px;
} */
.noBorder{
    border-bottom:0px;
}
.smaller{
    font-size:0.9em;
}
.title{
    font-weight:bold;
}
.subtitle{
    font-size:0.9em;
}
.separator{
    font-size:0.3em;
}
table{
    empty-cells: hide;
    /* table-layout: fixed; */
    font-size:1em;
    width:100%;
    text-align:center;
    border-collapse:collapse;
    border-spacing: 2px;
}
td{
    /* border-top:1px solid black; */
    /* border-left:1px solid #000000;
    border-right:1px solid #000000; */
    border-bottom:1px solid #4a4a4a;
    /* border-top:1px solid #000000; */
    padding:6px;
}
td{
    border-left:0px;
    border-right:0px;
}

table td:nth-child(even) {
    background: #f6f6f6;

}

.center {
  text-align:center;
}
</style>
