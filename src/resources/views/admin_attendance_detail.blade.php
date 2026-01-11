@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_attendance_detail.css') }}">
@endsection

@section('content')
<div class="container {{ $display['is_pending'] ? 'is-pending' : '' }}">

    <h1 class="page-title">勤怠詳細</h1>

    <form method="POST" action="{{ route('attendance.request.store', $work->id) }}">
        @csrf

        <div class="detail-card">
            <table class="detail-table">

                <tr>
                    <th>名前</th>
                    <td class="start-col">{{ $work->user->name }}</td>
                    <td class="tilde-col"></td>
                    <td class="end-col"></td>
                </tr>

                <tr>
                    <th>日付</th>
                    <td class="start-col">{{ $work->date->format('Y年') }}</td>
                    <td class="tilde-col"></td>
                    <td class="end-col">{{ $work->date->format('n月j日') }}</td>
                </tr>

                <tr>
                    <th>出勤・退勤</th>
                    <td class="start-col">
                        <input type="text"
                            name="work_start"
                            class="time-input"
                            value="{{ optional($display['work_start'])->format('H:i') }}"
                            {{ $display['is_pending'] ? 'readonly' : '' }}>
                    <td class="tilde-col">～</td>
                    <td class="end-col">
                        <input type="text"
                            name="work_end"
                            class="time-input"
                            value="{{ optional($display['work_end'])->format('H:i') }}"
                            {{ $display['is_pending'] ? 'readonly' : '' }}>
                    </td>
                </tr>

                @foreach ($display['rests'] as $index => $rest)
                <tr>
                    <th>休憩{{ $index + 1 }}</th>
                    <td class="start-col">
                        <input type="text"
                            name="rests[{{ $rest->id }}][rest_start]"
                            class="time-input"
                            value="{{ optional($rest->rest_start)->format('H:i') }}"
                            {{ $display['is_pending'] ? 'readonly' : '' }}>
                    <td class="tilde-col">～</td>
                    <td class="end-col">
                        <input type="text"
                            name="rests[{{ $rest->id }}][rest_end]"
                            class="time-input"
                            value="{{ optional($rest->rest_end)->format('H:i') }}"
                            {{ $display['is_pending'] ? 'readonly' : '' }}>
                    </td>
                </tr>
                @endforeach

                @if (!$display['is_pending'])
                <tr>
                    <th>休憩{{ count($display['rests']) + 1 }}</th>
                    <td class="start-col">
                        <input type="text"
                            name="rests[new][rest_start]"
                            class="time-input"
                            placeholder="--:--">
                    <td class="tilde-col">～</td>
                    <td class="end-col">
                        <input type="text"
                            name="rests[new][rest_end]"
                            class="time-input"
                            placeholder="--:--">
                    </td>
                </tr>
                @endif

                <tr>
                    <th>備考</th>
                    <td colspan="3">
                        <textarea
                            name="reason"
                            class="reason-input"
                            {{ $display['is_pending'] ? 'readonly' : '' }}>{{ old('reason', $display['reason']) }}</textarea>
                    </td>
                </tr>

            </table>
        </div>

        <div class="detail-button-area">
            @if ($display['is_pending'])
            <div class="request-warning">
                ※承認待ちのため修正はできません。
            </div>
            @else
            <button type="submit" class="edit-button">
                修正
            </button>
            @endif
        </div>

    </form>

    @if ($errors->any())
    <ul class="error-text">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif

</div>
@endsection