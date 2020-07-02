<tr>
<td class="header">
<a href="http://madaresonajo.com" style="display: inline-block;">
@if (trim($slot) === 'Madaresonajo')
<img src="http://madaresonajo.com/access_files/imgs/ic_main_logo.png" class="logo" alt="Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
