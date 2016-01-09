<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// Redimensionne une ressource image conformément aux dimensions spécifiées, coupe au besoin
function resize_image($I, $targetX, $targetY, $crop = false)
{
	
	$actualX = imagesx($I);
	$actualY = imagesy($I);
	
	$ratioX = $actualX / $targetX;
	$ratioY = $actualY / $targetY;
	
	
	// En cas de coupe
	if($crop):
	
		if(min($ratioX, $ratioY) > 1) {
			$temp = imagecreatetruecolor($actualX / min($ratioX, $ratioY), $actualY / min($ratioX, $ratioY));
			$bg = imagecolorallocate($temp, 255, 255, 255);
			imagefilledrectangle($temp, 0, 0, imagesx($temp), imagesy($temp), $bg); unset($bg);
			imagecopyresampled($temp, $I, 0, 0, 0, 0, imagesx($temp), imagesy($temp), $actualX, $actualY);
			$I = $temp;
			unset($temp);
		}
		else {
			if($ratioX < 1) $targetX *= $ratioX;
			if($ratioY < 1) $targetY *= $ratioY;
		}
		
		$temp = imagecreatetruecolor($targetX, $targetY);
		$bg = imagecolorallocate($temp, 255, 255, 255);
		imagefilledrectangle($temp, 0, 0, imagesx($temp), imagesy($temp), $bg); unset($bg);
		imagecopy($temp, $I, 0, 0, (imagesx($I) - $targetX) / 2, (imagesy($I) - $targetY) / 2, $targetX, $targetY);
		$I = $temp;
		unset($temp);
		
		return $I;
		# Fin de fonction
	
	
	// Sans coupe
	else:
	
		if(max($ratioX, $ratioY) > 1) {
			$targetX = $actualX / max($ratioX, $ratioY);
			$targetY = $actualY / max($ratioX, $ratioY);
		}
		else {
			$targetX = $actualX;
			$targetY = $actualY;
		}
		
		$temp = imagecreatetruecolor($targetX, $targetY);
		$bg = imagecolorallocate($temp, 255, 255, 255);
		imagefilledrectangle($temp, 0, 0, imagesx($temp), imagesy($temp), $bg); unset($bg);
		imagecopyresampled($temp, $I, 0, 0, 0, 0, $targetX, $targetY, $actualX, $actualY);
		$I = $temp;
		unset($temp);
		
		return $I;
		# Fin de fonction
	
	
	endif;
}


// Génère simplement une image pour GD depuis un fichier
function create_image_from_file($path, $ext = NULL)
{
	if(empty($ext))
		$ext = get_file_ext($path);
	
	switch(strtolower($ext)):
		case 'jpg':
		case 'jpeg':	return imagecreatefromjpeg($path);
		case 'gif':		return imagecreatefromgif($path);
		case 'png':		return imagecreatefrompng($path);
	endswitch;
	
	return NULL;
}


// Sauvegarde une image selon le format spécifié
function save_image_to_file($image, $path, $ext, $quality = 100)
{
	switch(strtolower($ext)):
		case 'jpg':
		case 'jpeg':
			imagejpeg($image, $path.'.'.$ext, $quality);
			break;
		case 'gif':
			imagegif($image, $path.'.'.$ext);
			break;
		case 'png':
			imagepng($image, $path.'.'.$ext, intval(round(9 - (9 * $quality / 100))));
			break;
	endswitch;
	
	return $path.'.'.$ext; # Retourne la location de l'image créée
}


// Récupère l'extension du nom de fichier
function get_file_ext($path)
{
	$split = strrpos($path, '.');
	if($split === FALSE) return NULL;
	else return substr($path, $split + 1);
}


// Récupère le nom du fichier sans extension
function get_file_name($path, $include_path = false)
{
	$title = $path;
	$extsplit = strrpos($path, '.');
	if($extsplit !== FALSE)
		$title = substr($title, 0, $extsplit); # Coupe de l'extension
	if(!$include_path) {
		$pathsplit = strrpos($title, '/');
		if($pathsplit !== FALSE)
			$title = substr($title, $pathsplit + 1); # Coupe du chemin, si nécessaire
	}
	return $title;
}


// Vérifie si le fichier est une image
function is_image($file)
{
	list($w, $h) = getimagesize($file);
	return $w > 0 && $h > 0;
}


// Récupère une image depuis le dossier upload selon la taille demandée
function get_upload($file, $width = 0, $height = 0, $crop = false)
{
	$dir = './uploads/images';
	$targetfile = get_file_name($file).'_'.$width.'x'.$height.($crop?'c':'r').'.'.get_file_ext($file);
	
	# Le fichier n'existe pas
	if(empty($file) || !file_exists($dir.'/'.$file))
		return NULL;
	
	# Le fichier existe et on demande la taille originale
	elseif($width == 0 || $height == 0)
		return UPLOADS_URL.'/images/'.$file;
	
	# Le fichier existe et on demande une taille spécifique pour laquelle on a un cache
	elseif(file_exists($dir.'/'.$targetfile))
		return UPLOADS_URL.'/images/'.$targetfile;
	
	# Le fichier existe et on demande une taille spécifique pour laquelle on n'a aucun cache
	else {
		$I = create_image_from_file($dir.'/'.$file);
		$I = resize_image($I, $width, $height, $crop);
		save_image_to_file($I, $dir.'/'.get_file_name($targetfile), get_file_ext($file), 100);
		return UPLOADS_URL.'/images/'.$targetfile;
	}
}


/* End of file image_helper.php */
/* Location: ./application/helpers/image_helper.php */