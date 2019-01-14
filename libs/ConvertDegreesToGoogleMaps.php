<?php
/** 
 * Class ConvertDegreesToGoogleMaps
 * Convert degrees minutes seconds to decimals for google maps
 *
 * @author Savio Resende
 * @website savioresende.com.br
 * @email lotharthesavior@gmail.com
 *
 * BSD LICENSE
 */

class ConvertDegreesToGoogleMaps
{
	protected 
		$LatDegrees, 
		$LatMinutes, 
		$LatSeconds, 
		$LongDegrees, 
		$LongMinutes, 
		$LongSeconds,
		$Decimals,
		$Result = array();

	public function __get( $name )
	{
		return $this->$name;
	}

	public function __set( $name , $value )
	{
		$this->$name = $value;
	}

	public function ConvertDegreesToDecimal( $LatDegrees , $LatMinutes , $LatSeconds , $LongDegrees , $LongMinutes , $LongSeconds )
	{
		$this->__set('LatDegrees',$LatDegrees);
		$this->__set('LatMinutes',$LatMinutes);
		$this->__set('LatSeconds',$LatSeconds);
		$this->__set('LongDegrees',$LongDegrees);
		$this->__set('LongMinutes',$LongMinutes);
		$this->__set('LongSeconds',$LongSeconds);

		$this->validateCoordinates();
		if( isset($this->Result['result']) && $this->Result['result'] == 'error' )
			return $this->Result;

		//latitud
			$lat_degrees = round(abs($this->LatDegrees));  
			$lat_minutes = abs($this->LatMinutes/60);
			$lat_seconds = round(abs($this->LatSeconds/3600),4);
			$decimals_lat = $lat_degrees+$lat_minutes+$lat_seconds;
	
		//longitud			
			$long_degrees = round(abs($this->LongDegrees));
			$long_minutes = abs($this->LongMinutes/60);
			$long_seconds = round(abs($this->LongSeconds/3600),4);
			$decimals_long = $long_degrees+$long_minutes+$long_seconds;

		if ($this->LongDegrees < 0)
		{
			$decimals_long = $decimals_long * -1;
		}
		$this->Result['result'] = 'ok';
		$this->Result['message'] = "Success!";
		$this->Result['coordinates'] = array('latitude'=>$decimals_lat,'longitude'=>$decimals_long);
		return $this->Result;
	}

	private function validateCoordinates()
	{
		// Latitudes
			if( !empty($this->LatDegrees) && $this->LatDegrees >= -90 && $this->LatDegrees  <= 90 ){
				// passed!
			}else{
				$this->Result['result'] = 'error';
				$this->Result['message'] = "Incorrect Latitudes Degrees ".$this->LatDegrees.".";
				return $this->Result;
			}

			if( !empty($this->LatMinutes) && $this->LatMinutes >= 0 && $this->LatMinutes  <= 59 ){
				// passed!
			}else{	
				$this->Result['result'] = 'error';
				$this->Result['message'] = "Incorrect Latitudes Minutes ".$this->LatMinutes.".";
				return $this->Result;
			}

			if( !empty($this->LatSeconds) && $this->LatSeconds >= 0 && $this->LatMinutes  <= 60 ){
				// passed!
			}else{ 
				$this->Result['result'] = 'error';
				$this->Result['message'] = "Incorrect Latitudes Seconds ".$this->LatSeconds.".";
				return $this->Result;
			}

		// Longitude
			if( !empty($this->LongDegrees) && $this->LongDegrees >= -90 && $this->LongDegrees  <= 90 ){
				// passed!
			}else{
				$this->Result['result'] = 'error';
				$this->Result['message'] = "Incorrect Longitude Degrees ".$this->LongDegrees.".";
				return $this->Result;
			}

			if( !empty($this->LongMinutes) && $this->LongMinutes >= -90 && $this->LongMinutes  <= 90 ){
				// passed!
			}else{
				$this->Result['result'] = 'error';
				$this->Result['message'] = "Incorrect Longitude Minutes ".$this->LongMinutes.".";
				return $this->Result;
			}

			if( !empty($this->LongSeconds) && $this->LongSeconds >= -90 && $this->LongSeconds  <= 90 ){
				// passed!
			}else{
				$this->Result['result'] = 'error';
				$this->Result['message'] = "Incorrect Longitude Seconds ".$this->LongSeconds.".";
				return $this->Result;
			}
	}
}
