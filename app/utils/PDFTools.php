<?php namespace App\Util;

class PDFTools
{
	public static function showPDF($html)
	{
		$pdf = \App::make('snappy.pdf.wrapper');
		$pdf->loadHTML($html)->setPaper('letter');

		return $pdf->stream();
	}
}