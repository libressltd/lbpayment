<div class="form-group">
    {{ Form::label($title, null, ['class' => 'control-label']) }}
    @if ($value === -1)
    <input class="form-control" type="date" name="{{ $name }}" value="" date-format="dd-MM-yyyy">
    @elseif (isset($value))
    <input class="form-control" type="date" name="{{ $name }}" value="{{ $value }}" date-format="dd-MM-yyyy">
    @else
    <input class="form-control" type="date" name="{{ $name }}" value="{{ date('Y-m-d') }}" date-format="dd-MM-yyyy">
    @endif
</div>