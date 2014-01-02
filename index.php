<?php

class CONST_dir{

	CONST TPL_DEFAULT		= 'base';
	CONST THEME_DEFAULT 	= 'default';
	CONST RENDER_DEFAULT	= 'html';
	CONST THEME 			= 'render';
	CONST TPL 				= 'tpl';
}
function create_render_html_modules($trait_prefix = 'trait_', $trait_ext = '.php'){

	$require_end 	= array();
	$render_list	= glob(CONST_dir::THEME.DIRECTORY_SEPARATOR.'*');
	$uses			= '';
	$uses_render	= '';

	foreach($render_list as $render_dir){

		if(is_dir($render_dir) === false) continue;
		$theme_list=glob($render_dir.DIRECTORY_SEPARATOR.'*');

		foreach($theme_list as $theme_dir){

			if(is_dir($theme_dir) === false) continue;

			$trait = $theme_dir.DIRECTORY_SEPARATOR.CONST_dir::TPL.DIRECTORY_SEPARATOR.$trait_prefix.CONST_dir::TPL.$trait_ext;

			$module_list=glob($theme_dir.DIRECTORY_SEPARATOR.CONST_dir::TPL.DIRECTORY_SEPARATOR.'*');

			foreach($module_list as $mdoule_dir){

				if(is_dir($mdoule_dir) === false) continue;

				$require = $mdoule_dir.DIRECTORY_SEPARATOR.$trait_prefix.'render_html_'.basename($mdoule_dir).$trait_ext;

				if(is_file($require) === true) {

					//echo $require.'<br />';
					require_once($require);

					$uses .= "\t".'use render_html_'.basename($mdoule_dir).';'."\n";
				}
			}
			if(is_file($trait) === true) {

				$require_end[$trait] = $trait;
			}
		}
		$eval = 'trait render_'.basename($render_dir).'_tmp {

'.$uses.'
}
';
		eval($eval);

		$require = $render_dir.DIRECTORY_SEPARATOR.$trait_prefix.'render_'.basename($render_dir).$trait_ext;

		if(is_file($require) === true) {

			//echo $require.'<br />';
			require_once($require);

			$uses_render .= "\t".'use render_'.basename($render_dir).';'."\n";
		}
	}
	$eval = 'trait render_tmp {

'.$uses_render.'
}
';
	eval($eval);

	foreach($require_end as $require){

		//echo $require.'<br />';
		require_once($require);
	}
}
create_render_html_modules();

class page{

	use tpl;
}

$infos['FOURN_FORM_ASSOCIATE_LIST'] = '
<option>1</option>
<option>2</option>
<option>3</option>
';
$infos['COND_FORM_ASSOCIATE_LIST'] = '
<option>test</option>
<option>Autre</option>
<option>Divers</option>
';

$infos_locked['COND_FORM_ASSOCIATE_LIST'] 	= true;
$infos_locked['FOURN_FORM_ASSOCIATE_LIST'] 	= true;

$tpl_params['tpl'] 					= 'base';
$tpl_params['theme'] 				= 'default';
$tpl_params['render'] 				= 'html';
$tpl_params['render_vars'] 			= $infos;
$tpl_params['render_vars_locked'] 	= $infos_locked;

$tpl = new page($tpl_params);
$tpl->load($tpl_params);

$tpl->remplace();
$tpl->out();

/*
$socle['title']										= '';
$socle['pt']										= '2';
$socle['sec']['title']								= 'Sécuriser le flux';
$socle['sec']['pt']									= '40';
$socle['ressource']['title']						= 'Consommations maximums';
$socle['ressource']['disk']['title']				= 'Consommation en espace disque';
$socle['ressource']['disk']['pt']					= '2';
$socle['ressource']['ram']['title']					= 'Consommation en espace RAM';
$socle['ressource']['ram']['pt']					= '2';
$socle['ressource']['core']['title']				= 'Consommation en coeur';
$socle['ressource']['core']['pt']					= '2';
$socle['ressource']['bdw']['title']					= 'Consommation en bande passante';
$socle['ressource']['bdw']['pt']					= '2';
$socle['prestation']['title']						= 'Prestations offertes';
$socle['prestation']['install']['title']			= 'Prestation d\'installation';
$socle['prestation']['install']['pt']				= '100';
$socle['prestation']['param']['title']				= 'Prestation de paramétrage';
$socle['prestation']['param']['pt']					= '100';
$socle['documentation']['title']					= 'Documentation offerte';
$socle['documentation']['architecture']['title']	= 'Documentation de l\'architecture';
$socle['documentation']['architecture']['pt']		= '10';
$socle['documentation']['installation']['title']	= 'Documentation de l\'installation';
$socle['documentation']['installation']['pt']		= '10';
$socle['documentation']['exploitation']['title']	= 'Documentation de l\'exploitation';
$socle['documentation']['exploitation']['pt']		= '10';
$socle['documentation']['maintenance']['title']		= 'Procédure de maintenance';
$socle['documentation']['maintenance']['pt']		= '10';
$socle['documentation']['manuel']['title']			= 'Manuel utilisateur';
$socle['documentation']['manuel']['pt']				= '10';
$socle['documentation']['param']['title']			= 'Guide de paramétrage';
$socle['documentation']['param']['pt']				= '10';

$sp['title']										= '';
$sp['prestation']['title']							= 'Prestations offertes';
$sp['prestation']['install']['title']				= 'Installation';
$sp['prestation']['install']['pt']					= '100';
$sp['prestation']['param']['title']					= 'Paramétrage sur mesure';
$sp['prestation']['param']['pt']					= '100';
$sp['prestation']['support_n1']['title']			= 'Assistance aux accès et habilitations';
$sp['prestation']['support_n1']['pt']				= '100';
$sp['prestation']['support_n2']['title']			= 'Assistance aux droits fins et formations';
$sp['prestation']['support_n2']['pt']				= '400';
$sp['prestation']['support_n3']['title']			= 'Assistance technique';
$sp['prestation']['support_n3']['pt']				= '500';
$sp['prestation']['animation_POC']['title']			= 'Animation et pilotage du POC';
$sp['prestation']['animation_POC']['pt']			= '500';
$sp['prestation']['club_utilisateur']['title']		= 'Animation du club d\'utilisateurs';
$sp['prestation']['club_utilisateur']['pt']			= '500';
$sp['prestation']['integrateur']['title']			= 'Intégrateur de la solution pour le POC';
$sp['prestation']['integrateur']['pt']				= '1000';
$sp['documentation']['title']						= 'Documentation offerte';
$sp['documentation']['architecture']['title']		= 'Documentation de l\'architecture';
$sp['documentation']['architecture']['pt']			= '10';
$sp['documentation']['installation']['title']		= 'Documentation de l\'installation';
$sp['documentation']['installation']['pt']			= '10';
$sp['documentation']['exploitation']['title']		= 'Documentation de l\'exploitation';
$sp['documentation']['exploitation']['pt']			= '10';
$sp['documentation']['maintenance']['title']		= 'Procédure de maintenance';
$sp['documentation']['maintenance']['pt']			= '10';
$sp['documentation']['manuel']['title']				= 'Manuel utilisateur';
$sp['documentation']['manuel']['pt']				= '10';
$sp['documentation']['param']['title']				= 'Guide de paramétrage';
$sp['documentation']['param']['pt']					= '10';

$prop['title']										= '';
$prop['prestation']['title']						= 'Prestations offertes';
$prop['prestation']['support_n1']['title']			= 'Assistance aux accès et habilitations';
$prop['prestation']['support_n1']['pt']				= '100';
$prop['prestation']['animation_POC']['title']		= 'Animation et pilotage du POC';
$prop['prestation']['animation_POC']['pt']			= '500';
$prop['prestation']['club_utilisateur']['title']	= 'Animation du club d\'utilisateurs';
$prop['prestation']['club_utilisateur']['pt']		= '500';
$prop['prestation']['integrateur']['title']			= 'Intégrateur de la solution pour le POC';
$prop['prestation']['integrateur']['pt']			= '1000';
$prop['documentation']['title']						= 'Documentation offerte';
$prop['documentation']['manuel']['title']			= 'Manuel utilisateur';
$prop['documentation']['manuel']['pt']				= '10';

$offre['title']										= 'Service socles Open Source (solutions et versions au choix du client)';
$offre['fw']										= $socle;
$offre['fw']['title']								= 'Service Firewall';
$offre['fw']['sec']['pt']							= '0';
$offre['fw']['prestation']['param']['pt']			= '0';
$offre['ca']										= $socle;
$offre['ca']['title']								= 'Service de certification';
$offre['ca']['sec']['pt']							= '0';
$offre['ca']['prestation']['param']['pt']			= '0';
$offre['dhcp']										= $socle;
$offre['dhcp']['title']								= 'Service d\'adressage';
$offre['dhcp']['sec']['pt']							= '0';
$offre['dhcp']['prestation']['param']['pt']			= '0';
$offre['network']									= $socle;
$offre['network']['title']							= 'Service réseau (dont VLAN privés)';
$offre['network']['sec']							= '0';
$offre['network']['prestation']['param']['pt']		= '0';
$offre['dns']										= $socle;
$offre['dns']['title']								= 'Service Noms de domaines';
$offre['dns']['sec']								= '0';
$offre['dns']['prestation']['param']['pt']			= '0';
$offre['ssh']										= $socle;
$offre['ssh']['title']								= 'Service accès à distance sécurisé';
$offre['ssh']['sec']['pt']							= '0';
$offre['ssh']['prestation']['param']['pt']			= '0';
$offre['http']										= $socle;
$offre['http']['title']								= 'Service Web';
$offre['http']['disk']['pt']						= '4';
$offre['http']['ram']['pt']							= '4';
$offre['http']['prestation']['param']['pt']			= '0';
$offre['mail']										= $socle;
$offre['mail']['title']								= 'Service Mail (IMAP & SMTP & Webmail)';
$offre['mail']['prestation']['param']['pt']			= '0';
$offre['samba4']									= $socle;
$offre['samba4']['title']							= 'Service Annuaire (LDAP & AD)';
$offre['samba4']['prestation']['param']['pt']		= '0';
$offre['nfs']										= $socle;
$offre['nfs']['title']								= 'Service de partage de dossiers (Samba, NFS)';
$offre['nfs']['sec']['pt']							= '0';
$offre['nfs']['disk']['pt']							= '100';
$offre['nfs']['ressource']['bdw']['pt']				= '100';
$offre['nfs']['prestation']['param']['pt']			= '0';
$offre['sgbd']										= $socle;
$offre['sgbd']['title']								= 'Service de bases de données';
$offre['sgbd']['disk']['pt']						= '100';
$offre['sgbd']['ressource']['bdw']['pt']			= '100';
$offre['sgbd']['prestation']['param']['pt']			= '0';
$offre['xterm']										= $socle;
$offre['xterm']['title']							= 'Service accès au bureau à distance';
$offre['xterm']['sec']['pt']						= '0';
$offre['xterm']['ressource']['bdw']['pt']			= '100';
$offre['xterm']['prestation']['param']['pt']		= '0';

$spec['title']										= 'Services spécifiques Open Source (solutions et versions au choix du client)';
$spec[0]											= $sp;

$dev['title']										= 'Services spécifiques à développer en Open Source';
$dev[0]												= $sp;

$sprop['title']										= 'Services propriétaires';
$sprop[0]											= $prop;

$duree['title']										= 'Valeur du point en fonction de la durée';
$duree['L']['title']								= 'Valeur du point pour les commandes au mois (31 jours)';
$duree['L']['pt_ratio']								= '100%';
$duree['XL']['title']								= 'Valeur du point pour les commandes au semestre (126 jours)';
$duree['XL']['pt_ratio']							= '80%';
$duree['XXL']['title']								= 'Valeur du point pour les commandes à l\'année (365 jours)';
$duree['XXL']['pt_ratio']							= '40%';

$palier['title']									= 'Valeur du point en fonction du nombre d\'utilisateurs';
$palier['L']['title']								= 'Valeur du point pour moins de 1000 utilisateurs';
$palier['L']['pt_ratio']							= '100%';
$palier['XL']['title']								= 'Valeur du point entre 1000 et 10000 utilisateurs';
$palier['XL']['pt_ratio']							= '1000%';
$palier['XXL']['title']								= 'Valeur du point entre 10000 et 100000 utilisateurs';
$palier['XXL']['pt_ratio']							= '80000%';
$palier['XXXL']['title']							= 'Valeur du point pour plus de 100000 utilisateurs';
$palier['XXXL']['pt_ratio']							= '200000%';

$sec['title']										= '';
$sec['L']['title']									= 'Preuve simple : Rêgles de l\'art contrôlables';
$sec['L']['pt_ratio']								= '101%';
$sec['XL']['title']									= 'Preuve simple : Rêgles de l\'art et procédures auditables';
$sec['XL']['pt_ratio']								= '120%';
$sec['XXL']['title']								= 'preuve irréfragable : mécanismes évolué de contrôle et de préservation';
$sec['XXL']['pt_ratio']								= '200%';

$sec_int											= $sec;
$sec_int['title']									= 'Niveau d\'intégrité des données';
$sec_int['L']['pt_ratio']							= '102%';
$sec_int['XL']['pt_ratio']							= '200%';
$sec_int['XXL']['pt_ratio']							= '400%';

$sec_conf											= $sec;
$sec_conf['title']									= 'Niveau de confidentialité des données';

$sec_rep											= $sec;
$sec_rep['title']									= 'Niveau d\'intégrité des données';
$sec_rep['L']['pt_ratio']							= '115%';
$sec_rep['XL']['pt_ratio']							= '200%';
$sec_rep['XXL']['pt_ratio']							= '600%';

$disp['title']										= 'Délais de rétablissement technique et de réponse du suppot';
$disp['L']['title']									= 'Délais de rétablissement en 7 jours';
$disp['L']['pt_ratio']								= '75%';
$disp['XL']['title']								= 'Délais de rétablissement en 2 jours';
$disp['XL']['pt_ratio']								= '80';
$disp['XXL']['title']								= 'Délais de rétablissement en 4 heures';
$disp['XXL']['pt_ratio']							= '90%';
$disp['XXXL']['title']								= 'Délais de rétablissement en 1 heure';
$disp['XXXL']['pt_ratio']							= '100%';

$disp_int['title']									= 'Périodes d\'intervention technique et de support';
$disp_int['L']['title']								= 'Jours ouvrés, entre 8h et 18h';
$disp_int['L']['pt_ratio']							= '75%';
$disp_int['XL']['title']							= '7j/7j, entre 8h et 18h';
$disp_int['XL']['pt_ratio']							= '80%';
$disp_int['XXL']['title']							= 'Jours ouvrés, 24h/24h';
$disp_int['XXL']['pt_ratio']						= '90%';
$disp_int['XXXL']['title']							= '7j/7j, 24h/24h';
$disp_int['XXXL']['pt_ratio']						= '100%';

$rest['title']										= 'Restitution et réversibilité';
$rest['L']['title']									= 'Sous 3 mois';
$rest['L']['pt_ratio']								= '60%';
$rest['XL']['title']								= 'Sous 1 mois';
$rest['XL']['pt_ratio']								= '80%';
$rest['XXL']['title']								= 'Sous 15 jours';
$rest['XXL']['pt_ratio']							= '100%';
$rest['XXXL']['title']								= 'Sous 1 jours';
$rest['XXXL']['pt_ratio']							= '200%';

$param['offre']										= $offre;
$param['spec']										= $spec;
$param['dev']										= $dev;
$param['sprop']										= $sprop;
$param['condition']['title']						= 'Conditions tarifaires';
$param['condition']['duree']						= $duree;
$param['condition']['palier']						= $palier;
$param['condition']['sec']['title']					= 'Conditions tarifaires liées au niveau de sécurité choisi';
$param['condition']['sec']['integrite']				= $sec_int;
$param['condition']['sec']['confidentialite']		= $sec_conf;
$param['condition']['sec']['nonrepudation']			= $sec_rep;
$param['condition']['sec']['title']					= 'Conditions tarifaires liées au niveau de disponibilité choisi';
$param['condition']['disp']['retablissement']		= $disp;
$param['condition']['disp']['intervention']			= $disp_int;
$param['condition']['disp']['reversibilite']		= $rest;
*/

?>