<?php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
class DashboardController extends AppController
{
    public $components = array('Paginator', 'Session','Email');
    function beforeFilter()
    {
        //echo $this->Session->read('Auth.User.id');
        if(!$this->Session->read('Auth.User.username') || !$this->Session->read('Auth.User.id'))
        $this->redirect('/users/register');
        if(!$this->Session->read('lang'))
            $this->Session->write('lang','e');
        $this->loadModel('User');
        $this->loadModel('Sale');
        $this->loadModel('RewardFrom');
    }
    public function index()
    {
        $this->paginate =array('conditions'=>array('user_id'=>$this->Session->read('Auth.User.id')),'limit'=>8) ;
        $carts = $this->paginate('Sale');
        $this->set('carts',$carts);
        $this->set('count',$this->Sale->find('count',array('conditions'=>array('user_id'=>$this->Session->read('Auth.User.id')))));
    }
    
    function setting()
    {
        //var_dump($_POST);die();
        $u = $this->User->findById($this->Session->read("Auth.User.id"));
        $this->set('fb_id',$u['User']['fbid']);
        $passwordHasher = new SimplePasswordHasher();
        if(isset($_POST)&& $_POST)
        {
            $q = $this->User->find('first',array('conditions'=>array('username'=>$this->Session->read('Auth.User.username'))));
           if(isset($_POST['password'])){ 
           $pass = $passwordHasher->hash(
            $_POST['password']
        );
           
           if($q['User']['password']==$pass)
           {
              foreach($_POST['data']['User'] as $k=>$v)
              {
                $arr[$k] = $v;
                $passwordHasher = new SimplePasswordHasher();
        $arr['password'] = $_POST['npassword'];
                //$arr['password'] = md5($_POST['npassword']);
                $this->User->id = $q['User']['id'];
                $this->User->save($arr);
                //$this->Session->setFlash('good','Data updates successfully!');
                $this->Session->setFlash('Data updates successfully!', 'default', array(), 'good');
                $this->redirect('setting');
              }
           }
           else
           {
            $this->Session->setFlash('Old Password do not match.', 'default', array(), 'bad');
            //$this->Session->setFlash('bad','Old Password do not match');
           // unset($_POST);
           $this->redirect('setting');
           }
           }
           else
           {
            if($_POST['data']['User'])
            foreach($_POST['data']['User'] as $k=>$v)
              {
                $arr[$k] = $v;
                //$arr['password'] = md5($_POST['npassword']);
                $this->User->id = $q['User']['id'];
                $this->User->save($arr);
                //$this->Session->setFlash('good','Data updates successfully!');
                $this->Session->setFlash('Data updated successfully!', 'default', array(), 'good');
                $this->redirect('setting');
              }
           }
        }
        $this->request->data = $this->User->find('first',array('conditions'=>array('User.username'=>$this->Session->read('Auth.User.username'))));
        //$this->set('model',$q);
        
    }

    function mycredit()
    {
        
        $q1 = $this->User->find('first',array('conditions'=>array('User.username'=>$this->Session->read('Auth.User.username'))));
        $this->paginate = array('conditions'=>array('user_id'=>$this->Session->read('Auth.User.id')),'limit'=>8);
        $q =  $this->paginate('RewardFrom');
        //echo $this->Session->read('Auth.User.username');
        //var_dump($q);die();
        $this->set('credit',$q);
        $this->set('count',$this->RewardFrom->find('count',array('conditions'=>array('user_id'=>$this->Session->read('Auth.User.id')))));
        if($q1)
        $this->set('tot',$q1['User']['my_coin']);
        else
        $this->set('tot',0);
    }
    function fbshare()
    {
        
        $arr['reward_date'] = date('Y-m-d');
        $arr['remark'] = 'Facebook Share';
        $arr['coins'] = '200';
        $arr['user_id'] = $this->Session->read('Auth.User.id');
        $q = $this->RewardFrom->find('first',array('conditions'=>array('user_id'=>$this->Session->read('Auth.User.id'),'reward_date'=>$arr['reward_date'],'remark'=>$arr['remark'])));
        if($q){
        $this->Session->setFlash('You have already shared this today','default',array(),'good');
        $this->redirect('mycredit');
        }
        else{
        if(isset($_GET['update'])){
        $q3 = $this->RewardFrom->find('first',array('conditions'=>array('user_id'=>$this->Session->read('Auth.User.id'),'reward_date'=>$arr['reward_date'],'remark'=>$arr['remark'])));
        if($q3){
        $this->Session->setFlash('You have already shared this today','default',array(),'good');
        $this->redirect('mycredit');
        }    
        $this->RewardFrom->create();
        $this->RewardFrom->save($arr);
        
        $q2 = $this->User->findById($this->Session->read('Auth.User.id'));
        $this->User->id = $this->Session->read('Auth.User.id');
        $arrs['my_coin'] = $q2['User']['my_coin']+$arr['coins'];
        $this->User->saveField('my_coin',$arrs['my_coin']);
        $this->redirect('mycredit');
        }
        
        if($_SERVER['SERVER_NAME']=='localhost')
        $url = 'http://localhost/savnpik/dashboard/fbshare?update';
        else
        $url = 'http://savnpik.com/dashboard/fbshare?update';
        $this->redirect('https://www.facebook.com/dialog/feed?app_id=1422309588028572&display=page&caption=SAVNPIK.COM&link=http%3A%2F%2Fsavnpik.com%2F&redirect_uri='.$url);     
        }
        
    }
    public function like()
    {
        $arr['reward_date'] = date('Y-m-d');
        $arr['remark'] = 'Facebook Like';
        $arr['coins'] = '500';
        $arr['user_id'] = $this->Session->read('Auth.User.id');
        $this->RewardFrom->create();
        $this->RewardFrom->save($arr);
        $q = $this->User->findById($this->Session->read('Auth.User.id'));
        $this->User->id = $this->Session->read('Auth.User.id');
        $tot = $q['User']['my_coin']-$arr['coin'];
        $this->User->saveField('my_coin',$tot);
        die();
    }
    public function unlike()
    {
        $arr['reward_date'] = date('Y-m-d');
        $arr['remark'] = 'Facebook Like';
        $arr['coins'] = '500';
        $arr['user_id'] = $this->Session->read('Auth.User.id');
        $q = $this->RewardFrom->find('first',array('conditions'=>$arr));
        $this->RewardFrom->delete($q['RewardFrom']['id']);
        $q = $this->User->findById($this->Session->read('Auth.User.id'));
        $this->User->id = $this->Session->read('Auth.User.id');
        $tot = $q['User']['my_coin']+$arr['coin'];
        $this->User->saveField('my_coin',$tot);
        die();
    }

    
  public function convertCurrency($amount, $from, $to){
    $url  = "https://www.google.com/finance/converter?a=$amount&from=$from&to=$to";
    $data = file_get_contents($url);
    preg_match("/<span class=bld>(.*)<\/span>/",$data, $converted);
    $converted = preg_replace("/[^0-9.]/", "", $converted[1]);
    return round($converted, 2);
  }

  # Call function  
  //echo convertCurrency(1, "USD", "INR");
  
    function deposit()
    {
        $this->loadModel('Payment');
        $this->paginate = array('conditions'=>array('user_id'=>$this->Session->read('Auth.User.id')),'limit'=>'8');
        $payment = $this->paginate('Payment');
        $this->set('payment',$payment);
        $this->set('count',$this->Payment->find('count',array('conditions'=>array('user_id'=>$this->Session->read('Auth.User.id')))));
        $u = $this->User->findById($this->Session->read('Auth.User.id'));
        $this->set('credit',$u['User']['my_balance']);
        $q1 = $this->User->find('first',array('conditions'=>array('User.username'=>$this->Session->read('Auth.User.username'))));
        $this->set('tot',$q1['User']['my_coin']);
       //var_dump($payment); 
        
    }
    function exchange($coin)
    {
        $q = $this->User->findById($this->Session->read('Auth.User.id'));
        if($q['User']['my_coin'] >= $coin)
        {
            if($coin==10000)
            {
                $this->User->id = $this->Session->read('Auth.User.id');
                $arr['my_coin'] = $q['User']['my_coin']-$coin;;
                if(!$q['User']['my_balance'])
                $q['User']['my_balance'] = 0;                
                $arr['my_balance'] = $q['User']['my_balance'] + $this->convertCurrency(5,'USD','AED');
                $this->User->save($arr);
                $this->RewardFrom->create();
                $arr2['remark'] = '10,000 coin exchange';
                $arr2['coins'] = '-10000';
                $arr2['reward_date'] = date('Y-m-d');
                $arr2['user_id'] = $this->Session->read('Auth.User.id');
                $this->RewardFrom->save($arr2);
                $this->loadModel('Payment');
                $arr3['user_id'] = $this->Session->read('Auth.User.iud');
                $arr3['stat'] = 'Completed'; 
                $arr3['amount'] = $arr['my_balance'];
                $arr3['on_date'] = date('Y-m-d');
                $arr3['remarks'] = 'Cash for '.' 10,000 coin exchange';
                $this->Payment->create();
                $this->Payment->save($arr3);
            }
            else
            if($coin == 18000)
            {
                $this->User->id = $this->Session->read('Auth.User.id');
                $arr['my_coin'] = $q['User']['my_coin']-$coin;;
                if(!$q['User']['my_balance'])
                $q['User']['my_balance'] = 0;                
                $arr['my_balance'] = $q['User']['my_balance'] + $this->convertCurrency(10,'USD','AED');
                $this->User->save($arr);
                $this->RewardFrom->create();
                $arr2['remark'] = '18,000 coin exchange';
                $arr2['coins'] = '-18000';
                $arr2['reward_date'] = date('Y-m-d');
                $arr2['user_id'] = $this->Session->read('Auth.User.id');
                $this->RewardFrom->save($arr2);
                $this->loadModel('Payment');
                $arr3['user_id'] = $this->Session->read('Auth.User.iud');
                $arr3['stat'] = 'Completed'; 
                $arr3['amount'] = $arr['my_balance'];
                $arr3['on_date'] = date('Y-m-d');
                $arr3['remarks'] = 'Cash for '.' 10,000 coin exchange';
                $this->Payment->create();
                $this->Payment->save($arr3);
            }
            else
            if($coin == 50000)
            {
                $this->User->id = $this->Session->read('Auth.User.id');
                $arr['my_coin'] = $q['User']['my_coin']-$coin;;
                if(!$q['User']['my_balance'])
                $q['User']['my_balance'] = 0;                
                $arr['my_balance'] = $q['User']['my_balance'] + $this->convertCurrency(35,'USD','AED');
                $this->User->save($arr); 
                $this->RewardFrom->create();
                $arr2['remark'] = '50,000 coin exchange';
                $arr2['coins'] = '-50000';
                $arr2['reward_date'] = date('Y-m-d');
                $arr2['user_id'] = $this->Session->read('Auth.User.id');
                $this->RewardFrom->save($arr2);
                $this->loadModel('Payment');
                $arr3['user_id'] = $this->Session->read('Auth.User.iud');
                $arr3['stat'] = 'Completed'; 
                $arr3['amount'] = $arr['my_balance'];
                $arr3['on_date'] = date('Y-m-d');
                $arr3['remarks'] = 'Cash for '.' 10,000 coin exchange';
                $this->Payment->create();
                $this->Payment->save($arr3);
            }
            else
            {
                $this->Session->setFlash('Invalid Coin Number','default',array(),'bad');
                $this->redirect('deposit');
            }
            $this->Session->setFlash($coin.' exchanged successfully!','default',array(),'good');
            $this->redirect('deposit');
        }
        else
        {
            $this->Session->setFlash('Invalid Request','default',array(),'bad');
            $this->redirect('deposit');
        }
        
    }
    
    public function request()
    {
        $u = $this->User->findById($this->Session->read('Auth.User.id'));
        //var_dump($u);
        $credit = $u['User']['my_balance'];
        if(isset($_POST['submit']))
        {
            $c = $_POST['credit'];
            $c_USD = $this->convertCurrency($_POST['credit'],"AED","USD");
            $email = $_POST['email'];
            if($c <= $credit)
            {
                //Email for User
                $emails = new CakeEmail();
                $emails->to($u['User']['email']);
                $emails->from(array('noreply@savnpik.com'=>'Savnpik'));
                $emails->subject("Request cheque in process");
                $emails->emailFormat('html');
                $msg = "Hi there,<br/><br/>Your request has been successfully submitted. It will take 3-4 business days to process the request. Please be patience till we get back to you.  <br/><br/>";
                $msg .= "Request Amount: ".$c." AED /".$c_USD." USD <br/> Paypal Email: ".$email;
                $emails->send($msg);
                unset($emails);
                
                //Email To Admin
                $emails = new CakeEmail();
                $admin = $this->User->find('first',array('conditions'=>array('User.role'=>2)));
                $emails->to($admin['User']['email']);
                $emails->from(array($u['User']['email']=>$u['User']['full_name']));
                $emails->subject("Request Cheque From Savnpik.com");
                $emails->emailFormat('html');
                $msg = "Hi there,<br/><br/>".$u['User']['full_name']." has requested a cheque.<br/>Request Details:<br/>";
                $msg .= "Request Amount: ".$c." AED /".$c_USD." USD <br/> Paypal Email: ".$email;
                
                if($emails->send($msg))
                {
                    $new_credit = $credit-$c;
                    $this->User->id = $this->Session->read('Auth.User.id');
                    $this->User->saveField('my_balance',$new_credit);
                    
                    $this->loadModel('Payment');
                    $payment['user_id'] = $this->Session->read('Auth.User.id');
                    $payment['amount'] = "-".$c;
                    $payment['on_date'] = date('Y-m-d H:i:s');
                    $payment['remarks'] =  "Amount Withdrawn(Request Cheque)";
                    $this->Payment->create();
                    $this->Payment->save($payment);
                    $this->Session->setFlash("Your Request has been sent successfully.",'default',array(),'good');
                    $this->redirect('request'); 
                }
            }
            else
            {
                $this->Session->setFlash('Invalid Request(You dont have sufficent funds)','default',array(),'bad');
                $this->redirect('request'); 
            }
        }
        $this->set('credit',$credit);
        
        
    }

}
