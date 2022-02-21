@extends('sites.weekly-menus')



@section('weekly-body')

            @if (count($menusAM) == 0)
                <tr>
                    <td colspan="7">
                        <p class="text-center">{{ trans('messages.no_data') }}</p>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @else
                <tr>
                    <td>
                        <strong>{{ trans('messages.noon') }}</strong> <br>
                        <!-- {{ ucfirst(trans('messages.from2')) }} 11:00 {{ trans('messages.to2') }} 13:30 -->
                    </td>
                    @foreach($menusAM as $key => $value)
                        <td class="{{ $key }}">
                            <div class="list-group"> 
                                @if (!empty($value))
                                    @foreach($value as $k => $v)
                                        <a  class="list-group-item modalButton"  data-toggle="modal" data-target="#modal-menu-create-edit" data-noon="1" data-item-type="menu" data-action-type="edit" data-id="{{ $v->id }}" class="list-group-item"> 
                                            <p class="list-group-item-heading">{{ $v->translate()->title }} <small>{{ $v->translate()->subtitle }}</small></p> 
                                            <p class="list-group-item-text"><small>{{ $v->label->translate()->name }} ({{ $v->label->price }} CHF)</small></p> 
                                        </a> 
                                    @endforeach
                                @endif
                                <a  class="list-group-item addButton modalButton" data-toggle="modal" data-target="#modal-menu-create-edit" data-noon="1" data-item-type="menu" data-site="{{ $site->id }}" data-day="{{ $key }}" data-id="0" data-action-type="create"> 
                                
                                <i class="ti-plus"></i>    
                                </a> 
                            </div>
                        </td>
                    @endforeach
                </tr>

            @endif

            @if (count($menusPM) == 0)
                <tr>
                    <td colspan="7">
                        <p class="text-center">{{ trans('messages.no_data') }}</p>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @else
                <tr>
                    <td><strong>{{ trans('messages.evening') }}</strong> <br>
                        <!-- {{ ucfirst(trans('messages.from2')) }} 17:30 {{ trans('messages.to2') }} 19:30 -->
                    </td>
                    
                    @foreach($menusPM as $key => $value)
                        <td class="{{ $key }}">
                            <div class="list-group"> 
                                @if (!empty($value))
                                    @foreach($value as $k => $v)
                                        <a  class="list-group-item modalButton"  data-toggle="modal" data-target="#modal-menu-create-edit" data-item-type="menu" data-action-type="edit" data-noon="0" data-id="{{ $v->id }}" class="list-group-item"> 
                                            <p class="list-group-item-heading">{{ $v->translate()->title }} <small>{{ $v->translate()->subtitle }}</small></p> 
                                            <p class="list-group-item-text"><small>{{ $v->label->translate()->name }} ({{ $v->label->price }} CHF)</small></p> 
                                        </a> 
                                    @endforeach
                                @endif
                                <a  class="list-group-item addButton modalButton" data-toggle="modal" data-target="#modal-menu-create-edit" data-noon="0" data-item-type="menu" data-day="{{ $key }}" data-id="0" data-site="{{ $site->id }}" data-action-type="create"> 
                                    <i class="ti-plus"></i>    
                                </a> 
                            </div>
                        </td>
                    @endforeach
                </tr>

            @endif

            <tr style="background-color: fbfbfb;">
            <td>{{ trans('messages.notice') }}</td>
                @foreach($notices as $key => $value)
                        <td class="{{ $key }}">
                            <div class="list-group"> 
                                @if (!empty($value))
                                    @foreach($value as $k => $v)
                                        <a  class="list-group-item modalButton"   data-toggle="modal" data-item-type="notice" data-day="{{ $key }}" data-action-type="edit" data-id="{{ $v->id }}" class="list-group-item"> 
                                            <p class="list-group-item-heading">{{ $v->translate()->title }}</p> 
                                        </a> 
                                    @endforeach
                                @endif
                                <a  class="list-group-item addButton modalButton" data-toggle="modal" data-item-type="notice" data-important="false" data-day="{{ $key }}" data-id="0" data-site="{{ $site->id }}" data-year="2018" data-action-type="create"> 
                                   <i class="ti-plus"></i>    
                                </a> 
                            </div>
                        </td>
                @endforeach
            </tr>

    @endsection
