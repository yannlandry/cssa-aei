<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events_model extends CI_Model {
/* Modèle pour charger les événements */



	# Quelques constantes
	const PAGE_ID = 'sfuo.feuo';
	const ACCESS_TOKEN = '488502801275566|ePvChPH9-fxLjykgVxyMbcFA0zM';
	
	
	
	# Récupère une liste des événements
	public function get_all_events()
	{
		$cache = './application/cache/events/list.tmp';

		if(file_exists($cache) && time() - filemtime($cache) < 3600)
			return unserialize(file_get_contents($cache));

		else {
			$curl = curl_init();

			curl_setopt($curl, CURLOPT_URL, 'https://graph.facebook.com/'.self::PAGE_ID.'/events?access_token='.self::ACCESS_TOKEN);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

			$result = json_decode(curl_exec($curl));

			if(property_exists($result, 'data')) {
				$result = $result->data;
				file_put_contents($cache, serialize($result));
			}
			else {
				addFlash("Erreur lors de la communication avec Facebook. Une erreur de type ".$result->error->type
					." a été retournée avec le message suivant : (".$result->error->code
					.") <strong>".$result->error->message."</strong>", 'danger');
				$result = array();
			}

			return $result;
		}
	}



	# Récupère un événement seul
	public function get_event($id)
	{
		if($id == 0) return false;

		$cache = './application/cache/events/event_'.$id.'.tmp';

		if(file_exists($cache) && filemtime($cache) < 3600)
			return unserialize(file_get_contents($cache));

		else {
			$curl = curl_init();

			curl_setopt($curl, CURLOPT_URL, 'https://graph.facebook.com/'.$id.'?access_token='.self::ACCESS_TOKEN);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

			$result = json_decode(curl_exec($curl));

			if(property_exists($result, 'error')) {
				addFlash("Erreur lors de la communication avec Facebook. Une erreur de type ".$result->error->type
					." a été retournée avec le message suivant : (".$result->error->code
					.") <strong>".$result->error->message."</strong>", 'danger');
				return false;
			}

			file_put_contents($cache, serialize($result));
			return $result;
		}
	}
	
	
	
}

/* End of file events_model.php */
/* Location: ./application/models/events_model.php */