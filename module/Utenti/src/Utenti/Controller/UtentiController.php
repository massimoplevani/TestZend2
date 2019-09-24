<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Utenti\Controller;

use Utenti\Form\registrazioneForm; 
use Utenti\Form\polizzaForm; 
use Utenti\InputFilter\RegistrazionePost;
use Utenti\InputFilter\PolizzaPost;
use Zend\Db\Adapter;

use Utenti\Model\Utenti;
use Utenti\Model\Polizza;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class UtentiController extends AbstractActionController
{

    protected $adapter;


    public function indexAction()
    {
        return new ViewModel();
    }   


    public function registrazioneAction() {

    	$form =  new registrazioneForm();

    	if($this->request->isPost()){
    		$form->setInputFilter(new RegistrazionePost($this->getServiceLocator()));
    		$form->setData($this->request->getPost());
    		if($form->isValid()){

    			/*salvare*/
                $data = $form->getData();
                $data = $this->prepareDataReg($data);
                $dbAdapter = $this->getAdapter();
                $oUtenti = new Utenti($dbAdapter);
                $check = $oUtenti->salvaUtente($data);    			
    			if($check){
    			 	return $this->redirect()->toRoute('login');
    			}
    		}
    	}

    	$view = new ViewModel(array(
    		'form' => $form
    	));
		$view->setTemplate("utenti/registrazione/registrazione.phtml");
		return $view;
    }

    public function nuovaPolizzaAction(){

        $aDatiUtente = (array) $this->identity();

        $dbAdapter = $this->getAdapter();
        $oPolizza = new Polizza($dbAdapter);
        $aTipiPolizza = $oPolizza->getTipiPolizza();
        $form =  new polizzaForm($aDatiUtente,$aTipiPolizza);
        $messages = null;
        if($this->request->isPost()){
            $form->setInputFilter(new PolizzaPost($this->getServiceLocator()));
            $form->setData($this->request->getPost());
            
            if($form->isValid()){
                /*salvare*/
                $data = $form->getData();
                $idPolizza = $this->request->getPost()->idpolizza;
                $sCompagnia = $this->request->getPost()->compagnia;
                $check = $oPolizza->CheckNonExistPolizza($idPolizza, $sCompagnia);

                if($check){
                    $aData = $this->prepareDataPolizza($data);
                    $check = $oPolizza->salvaPolizza($aData);              
                    if($check){
                        return $this->redirect()->toRoute('elenco-polizza');
                    }
                } else{
                    $messages = "Esiste già una polizza con questo ID $idPolizza e Compagnia '$sCompagnia'!";
                }
          
            }
        }


        $view = new ViewModel(array(
            'form' => $form,
            'title'=> 'Inserisci una nuova polizza',
            'messages' => $messages
        ));
        $view->setTemplate("utenti/polizza/polizza.phtml");
        return $view;

    }


    public function elencoPolizzaAction(){

        $aDatiUtente = (array) $this->identity();
        $dbAdapter = $this->getAdapter();
        $oPolizza = new Polizza($dbAdapter);
        $aPolizze = $oPolizza->getPolizze( $aDatiUtente['id']);
        
        $view = new ViewModel(array(
            'aPolizze' =>$aPolizze
        ));
        $view->setTemplate("utenti/polizza/elencoPolizza.phtml");
        return $view;

    }


    public function modificaPolizzaAction(){

        $id= $this->params('id');
        $aDatiUtente = (array) $this->identity();
        $dbAdapter = $this->getAdapter();
        $oPolizza = new Polizza($dbAdapter);
        $aTipiPolizza = $oPolizza->getTipiPolizza();
        $aDatiPolizza = $oPolizza->getPolizzaByID($id);
        unset( $aDatiPolizza['DataCreazione']);
        unset( $aDatiPolizza['DataAggiornamento']);
        $messages = null;

        if(empty($aDatiPolizza)){
            $messages = $this->translate('Nessuna polizza trovata!');
        } else{

            $date=date_create($aDatiPolizza['DataEmissione']);
            $aDatiPolizza['DataEmissione'] = date_format($date,"d-m-Y"); 
             $date=date_create($aDatiPolizza['DataScadenza']);
            $aDatiPolizza['DataScadenza'] = date_format($date,"d-m-Y"); 
         
            $form =  new polizzaForm($aDatiUtente,$aTipiPolizza,$aDatiPolizza);

              if($this->request->isPost()){
                $form->setInputFilter(new PolizzaPost($this->getServiceLocator()));
                $form->setData($this->request->getPost());
                
                if($form->isValid()){
                    /*salvare*/
                    $data = $form->getData();
                    $aData = $this->prepareDataPolizza($data);
                    unset($aData['DataCreazione']);
                    $check = $oPolizza->CheckNonExistPolizzaUguale($aData);

                    if($check){
                        $check = $oPolizza->modificaPolizza($aData,$id);              
                        if($check){
                             $messages = "Polizza Modificato con sucesso!";
                        }
                    } else{
                        $messages = "Esiste già una polizza uguale!";
                    }
              
                }
            }

        }
        

        $view = new ViewModel(array(
            'form' => $form,
            'title'=> 'Modifica la tua polizza',
            'messages' => $messages
        ));
        $view->setTemplate("utenti/polizza/polizza.phtml");
        return $view;

    }



    public function profiloAction() {

        if (!$this->identity()) {
            $this->redirect()->toRoute('login');
         }
       
        $data = (array) $this->identity();

        $aDatiUtente = $this->prepareDataProfilo($data);    

        $view = new ViewModel(array(
            'aDatiUtente' => $aDatiUtente
        ));
        $view->setTemplate("utenti/profilo/profilo.phtml");
        return $view;
    }


    public function prepareDataProfilo($data){

            $aDatiUtente = $data;
            $date=date_create($aDatiUtente['DataCreazione']);
            $aDatiUtente['Data Creazione'] = date_format($date,"d-m-Y H:i:s"); 
            $date=date_create($aDatiUtente['DataAggiornamento']);
            $aDatiUtente['Data Aggiornamento'] = date_format($date,"d-m-Y H:i:s"); 

            unset($aDatiUtente['DataCreazione']); 
            unset($aDatiUtente['DataAggiornamento']); 
            unset($aDatiUtente['Password']); 

            return $aDatiUtente;
    }


   
    public function prepareDataReg($data){

            $config = $this->getConfigAdapter();
            $staticKey = $config['static_key'];
            $data['password']  = md5($staticKey.$data['password']);
            date_default_timezone_set("Europe/Rome");
            $date = new \DateTime();
            $data['DataCreazione']  =  $date->format('Y-m-d H:i:s');

            unset($data['inviaRegistrazione']);
            unset($data['checkPassword']);

            return $data;
    }


    public function prepareDataPolizza($aData){

            $aDataPolizza['IDPolizza'] = $aData['idpolizza'];
            $aDataPolizza['IDTipoPolizza'] = (int)  $aData['tipopolizza'];
            $aDataPolizza['IDUtente'] = $aData['IDUtente'];
            $aDataPolizza['Compagnia'] = $aData['compagnia'];
            $aDataPolizza['NomePolizza'] = $aData['nomePolizza'];
            $aDataPolizza['PremioPagato'] = $aData['premioPagato'];
            $dateEmissione=date_create($aData['dataEmissione']);
            $aDataPolizza['DataEmissione'] = date_format($dateEmissione,"Y-m-d"); 
            $dataScadenza=date_create($aData['dataScadenza']);
            $aDataPolizza['DataScadenza'] = date_format($dataScadenza,"Y-m-d"); 
    

            if(!empty($aData['marca'])){
                 $aDataPolizza['Marca'] = $aData['marca'];
            }

            if(!empty($aData['modello'])){
                 $aDataPolizza['Modello'] = $aData['modello'];
            }

            if(!empty($aData['targa'])){
                 $aDataPolizza['Targa'] = $aData['targa'];
            }

            if(!empty($aData['indirizzo'])){
                 $aDataPolizza['Indirizzo'] = $aData['indirizzo'];
            }

            date_default_timezone_set("Europe/Rome");
            $date = new \DateTime();
            $aDataPolizza['DataCreazione']  =  $date->format('Y-m-d H:i:s');

            return $aDataPolizza;
    }

    public function getAdapter()
    {
       if (!$this->adapter) {
          $sm = $this->getServiceLocator();
          $this->adapter = $sm->get('Zend\Db\Adapter\Adapter');
       }
       return $this->adapter;
    }


    protected function getConfigAdapter(){

       return $this->getServiceLocator()->get('Config');

    }
}
