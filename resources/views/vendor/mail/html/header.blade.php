<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{asset('/projetos/comercial/public/logo.png')}}" class="logo" alt="Hospital Daher">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
