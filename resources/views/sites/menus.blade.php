
<table class="MsoTableGrid" style="border-collapse:collapse;border:none">
<tr>
    <td></td>
    @foreach($labels as $label)
    <td><p class="MsoNormal" style="margin-top:6.0pt;margin-right:0cm;margin-bottom:6.0pt;margin-left:0cm"><b><span lang="FR-CH" style="font-size:10.0pt; font-family:Arial,sans-serif">{{ $label->name}} (CHF {{ $label->price }})</span></b></p></td>
    @endforeach
</tr>
@foreach($days as $key => $day)
    <tr class="row-{{$key}}">
        <th>{{ $day["name"] }}</th>
        <td valign="top" colspan="3"><p class="MsoNormal">@foreach($day["notices"] as $notice){{ $notice->title}} @endforeach</p></td> 
    </tr>
    <tr  class="row-{{$key}}">
        <td></td>

        @foreach($labels as $label)
        <td valign="top">@if(isset($day["menus"][$label->id]))<p class="Mensa-Title"><span lang="FR">{{ $day["menus"][$label->id]->title }}</span></p><p class="Mensa-Garniture"><span lang="FR">{{ $day["menus"][$label->id]->accompaniment }}</span></p>@endif</td>

        @endforeach
    </tr>
@endforeach
</table>

<p class="MsoNormal"><span lang="FR-CH" style="font-size:10.0pt">&nbsp;</span></p>

