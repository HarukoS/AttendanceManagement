@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/approve.css') }}">
@endsection

@section('content')
<div class="container">
    <h1 class="page-title">勤怠詳細</h1>

    <div class="detail-card">
        <table class="detail-table">
            <tr>
                <th>名前</th>
                <td class="start-col">{{ $request->user->name }}</td>
                <td class="tilde-col"></td>
                <td class="end-col"></td>
            </tr>

            <tr>
                <th>日付</th>
                <td class="start-col">{{ optional($request->work->date)->format('Y年') }}</td>
                <td class="tilde-col"></td>
                <td class="end-col">{{ optional($request->work->date)->format('n月j日') }}
                </td>
            </tr>

            <tr>
                <th>出勤・退勤</th>
                <td class="start-col">
                    {{ optional($display['work_start'])->format('H:i') ?? '-' }}
                </td>
                <td class="tilde-col">～</td>
                <td class="end-col">
                    {{ optional($display['work_end'])->format('H:i') ?? '-' }}
                </td>
            </tr>

            @foreach($display['rests'] as $index => $rest)
            <tr>
                <th>休憩{{ $index + 1 }}</th>
                <td class="start-col">
                    {{ optional($rest->rest_start)->format('H:i') ?? '-' }}
                </td>
                <td class="tilde-col">～</td>
                <td class="end-col">
                    {{ optional($rest->rest_end)->format('H:i') ?? '-' }}
                </td>
            </tr>
            @endforeach

            <tr>
                <th>備考</th>
                <td colspan="3" class="reason-input">{{ $display['reason'] ?? '-' }}</td>
            </tr>

        </table>
    </div>

    <div class="detail-button-area">
        @if($request->status === 0)
        <form method="POST" action="{{ route('admin.request.approve', $request->id) }}">
            @csrf
            <button type="submit" class="approve-button">
                承認
            </button>
        </form>
        @else
        <div class="approved-button">
            承認済み
        </div>
        @endif
    </div>
</div>
@endsection