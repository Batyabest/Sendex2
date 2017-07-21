<?php
/** @var array $scriptProperties */
/** @var Sendex $Sendex */
$Sendex = $modx->getService('sendex','Sendex',$modx->getOption('sendex_core_path',null,$modx->getOption('core_path').'components/sendex/').'model/sendex/',$scriptProperties);
if (!($Sendex instanceof Sendex)) return '';

if (empty($tplUnsubscribe)) {$tplUnsubscribe = 'tpl.Sendex.unsubscribe';}
$ids = $_GET['ids'];
$user = $this->xpdo->getObject('sxUser', array('id' => $ids));
$user_id = $user->get('id');
$email = $user->get('email');

$placeholders = $user->toArray();

$Question = $this->xpdo->getCollection('sxUnsubscribeQuestion');
foreach ($Question as $k => $res) {
	$quest[] = $res->get('question');
}

$placeholders = array_merge(
	$user->toArray(),
	$quest
);
$placeholders['snippet'] = 'AjaxScribe';
$placeholders['form'] = $tplUnsubscribe;
/*print"<pre>";
print_r($placeholders);
print"</pre>";*/

$output = $modx->runSnippet('AjaxForm',$placeholders);
//$output = $modx->getChunk($tplUnsubscribe, $placeholders);

return $output;