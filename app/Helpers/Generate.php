<?php

namespace App\Helpers;

use App\Models\Participant;
use App\Models\Sample;
use Carbon\Carbon;

class Generate
{
    public static function participantNo()
    {
        $participant_no = '';
        $yearStart = Carbon::now();
        $latestParticipantNo = Participant::select('participant_no')->orderBy('id', 'desc')->first();

        if ($latestParticipantNo) {
            $participantNumberSplit = explode('-', $latestParticipantNo->participant_no);
            $participantNumberYear = (int) filter_var($participantNumberSplit[0], FILTER_SANITIZE_NUMBER_INT);

            if ($participantNumberYear == $yearStart->year) {
                $participant_no = $participantNumberSplit[0].'-'.((int) filter_var($participantNumberSplit[1], FILTER_SANITIZE_NUMBER_INT) + 1).'P';
            } else {
                $participant_no = 'BRC'.$yearStart->year.'-100P';
            }
        } else {
            // $dig= str_pad($dig, 3, '0', STR_PAD_LEFT);
            // str_pad($value, 8, '0', STR_PAD_LEFT);
            $participant_no = 'BRC'.$yearStart->year.'-100P';
        }

        return $participant_no;
    }

    public static function sampleNo()
    {
        $sample_no = '';
        $yearStart = Carbon::now();
        $latestSampleNo = Sample::select('sample_no')->orderBy('id', 'desc')->first();

        if ($latestSampleNo) {
            $sampleNumberSplit = explode('-', $latestSampleNo->sample_no);
            $sampleNumberYear = (int) filter_var($sampleNumberSplit[0], FILTER_SANITIZE_NUMBER_INT);

            if ($sampleNumberYear == $yearStart->year) {
                $sample_no = $sampleNumberSplit[0].'-'.((int) filter_var($sampleNumberSplit[1], FILTER_SANITIZE_NUMBER_INT) + 1).'S';
            } else {
                $sample_no = 'PTSP'.$yearStart->year.'-100S';
            }
        } else {
            $sample_no = 'PTSP'.$yearStart->year.'-100S';
        }

        return $sample_no;
    }
}