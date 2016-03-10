<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.plugin.plugin');
define('MV_SOCIAL_BUTTONS_URL', JURI::base() . "plugins/content/mvsocialbuttons/");
class plgContentMVSocialButtons extends JPlugin {
public function onContentPrepare($context, &$article, &$params, $limitstart) {
        $app = JFactory::getApplication();
/* @var $app JApplication */
// Do not render the buttons in administration area
        if($app->isAdmin()) {
            return;
        }       
        $doc   = JFactory::getDocument();
        /* @var $doc JDocumentHtml */
        $docType = $doc->getType();
// Joomla! must render content of this plugin only in HTML document
        if(strcmp("html", $docType) != 0){
            return;
        }       
        $currentOption = JRequest::getCmd("option");
        if(($currentOption != "com_content") OR !isset($article) OR empty($article->id) OR !isset($this->params)) {
            return;            
        }
        JPlugin::loadLanguage('plg_mvsocialbuttons');
        $buttons = $this->getButtons($article);
        $position = $this->params->get('position');
        switch($position){
            case 1:
                $article->text = $buttons . $article->text;
                break;
            case 2:
                $article->text = $article->text . $buttons;
                break;
            default:
                $article->text = $buttons . $article->text . $buttons;
                break;
        }
                return true;
    }
    private function getButtons(&$article){  
        $view        = $this->params->get('view');
        $currentView = JRequest::getWord("view");
// Check where we are able to show buttons?
        $showInArticles     = $this->params->get('showInArticles');       
/** Check for selected views, which will display the buttons. **/   
/** If there is a specific set and do not match, return an empty string.**/
        if($showInArticles AND (strcmp("article", $currentView) != 0)){
            return "";
        }       
        $excludedCats = $this->params->get('excludeCats');
        if(!empty($excludedCats)){
            $excludedCats = explode(',', $excludedCats);
        }
        settype($excludedCats, 'array');
        JArrayHelper::toInteger($excludedCats);
        $excludeArticles = $this->params->get('excludeArticles');
        if(!empty($excludeArticles)){
            $excludeArticles = explode(',', $excludeArticles);
        }
        settype($excludeArticles, 'array');
        JArrayHelper::toInteger($excludeArticles);
// Included Articles
        $includedArticles = $this->params->get('includeArticles');
        if(!empty($includedArticles)){
            $includedArticles = explode(',', $includedArticles);
        }
        settype($includedArticles, 'array');
        JArrayHelper::toInteger($includedArticles);      
        if(!in_array($article->id, $includedArticles)) {
// Check exluded views
            if(in_array($article->catid, $excludedCats) OR in_array($article->id, $excludeArticles)){
                return "";
            }
        }
        $html = "";      
        $style = MV_SOCIAL_BUTTONS_URL . "style.css";
        $doc   = JFactory::getDocument();
/* @var $doc JDocumentHtml */
        $doc->addStyleSheet($style);       
        $html .= '<div class="mv-social-buttons-box">';
        if($this->params->get('showTitle')){
            $html .= '<h4>' . $this->params->get('title') . '</h4>';
        }
        $html .='<div class="' . $this->params->get('displayLines') . '">';
        $html .= '<div class="' . $this->params->get('displayIcons') . '">';
        $url = JURI::base();
        $url = new JURI($url);
        $root= $url->getScheme() ."://" . $url->getHost();
        $link = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catslug), false);
        $link = $root.$link;
        $title      = rawurlencode($article->title);
        $link       = rawurlencode($link);   
        if($this->params->get("displayDelicious")) {
            $html .= $this->getDeliciousButton($title, $link);
        }
        if($this->params->get("displayDigg")) {
            $html .= $this->getDiggButton($title, $link);
        }
        if($this->params->get("displayFacebook")) {
            $html .= $this->getFacebookButton($title, $link);
        }
        if($this->params->get("displayGoogle")) {
            $html .= $this->getGoogleButton($title, $link);
        }
        if($this->params->get("displayTechnorati")) {
            $html .= $this->getTechnoratiButton($title, $link);            
        }
        if($this->params->get("displayTwitter")) {
            $html .= $this->getTwitterButton($title, $link);
        }
        if($this->params->get("displayLinkedIn")) {
            $html .= $this->getLinkedInButton($title, $link);
        }
        if($this->params->get("displayVkruButton")) {
            $html .= $this->getVkruButton($title, $link);
        }
        if($this->params->get("displayLivejButton")) {
            $html .= $this->getLivejButton($title, $link);
        }
	if($this->params->get("displayMoymirButton")) {
            $html .= $this->getMoymirButton($title, $link);
        }
	if($this->params->get("displayYaruButton")) {
            $html .= $this->getYaruButton($title, $link);
        }
	if($this->params->get("displayOdnoklassnikiButton")) {
            $html .= $this->getOdnoklassnikiButton($title, $link);
        }
	if($this->params->get("displayLiveinternetButton")) {
            $html .= $this->getLiveinternetButton($title, $link);
        }
	if($this->params->get("displayBobrdobrButton")) {
            $html .= $this->getBobrdobrButton($title, $link);
        }
// Get extra social buttons
        $html .= $this->getExtraButtons($title, $link, $this->params);       
        $html .= '</div></div></div>';
        return $html;
    }
    private function getExtraButtons($title, $url, &$params) {       
        $html  = "";
        // Extra buttons
        for($i=1; $i < 6;$i++) {
            $btnName = "ebuttons" . $i;
            $extraButton = $params->get($btnName, "");
            if(!empty($extraButton)) {
                $extraButton = str_replace("{URL}", $url,$extraButton);
                $extraButton = str_replace("{TITLE}", $title,$extraButton);
                $html  .= $extraButton;
            }
        }        
        return $html;
    }
/** Кнопка закладки Delicious. **/ 
    private function getDeliciousButton($title, $link){            
        $img_url = MV_SOCIAL_BUTTONS_URL . "images/" . $this->params->get('style') . "/delicious.png";        
        return '<a rel="nofollow" href="http://del.icio.us/post?url=' . $link . '&amp;title=' . $title . '" title="' . JText::sprintf("Delicious") . '" target="_blank" >
        <img src="' . $img_url . '" alt="' . JText::sprintf("Delicious") . '" />
        </a>';    
    }
/** Кнопка закладки Digg. **/  
    private function getDiggButton($title, $link){        
        $img_url = MV_SOCIAL_BUTTONS_URL . "images/" . $this->params->get('style') . "/digg.png";       
        return '<a rel="nofollow" href="http://digg.com/submit?url=' . $link . '&amp;title=' . $title . '" title="' . JText::sprintf("Digg") . '" target="_blank" >
        <img src="' . $img_url . '" alt="' . JText::sprintf("Digg") . '" />
        </a>';    
    }
    /** Кнопка закладки Facebook. **/ 
    private function getFacebookButton($title, $link){       
        $img_url = MV_SOCIAL_BUTTONS_URL . "images/" . $this->params->get('style') . "/facebook.png";        
        return '<a rel="nofollow" href="http://www.facebook.com/sharer.php?u=' . $link . '&amp;t=' . $title . '" title="' . JText::sprintf("Facebook") . '" target="_blank" >
        <img src="' . $img_url . '" alt="' . JText::sprintf("Facebook") . '" />
        </a>';  
    }
/** Кнопка закладки Google. **/ 
    private function getGoogleButton($title, $link){
        $img_url = MV_SOCIAL_BUTTONS_URL . "images/" . $this->params->get('style') . "/google.png";
        return '<a rel="nofollow" href="http://www.google.com/bookmarks/mark?op=edit&amp;bkmk=' . $link . '" title="' . JText::sprintf("Google Bookmarks") . '" target="_blank" >
        <img src="' . $img_url . '" alt="' . JText::sprintf("Google Bookmarks") . '" />
        </a>';   
    }
/** Кнопка закладки в Technorati. **/  
    private function getTechnoratiButton($title, $link){
        $img_url = MV_SOCIAL_BUTTONS_URL . "images/" . $this->params->get('style') . "/technorati.png";
        return '<a rel="nofollow" href="http://technorati.com/faves?add=' . $link . '" title="' . JText::sprintf("Technorati") . '" target="_blank" >
        <img src="' . $img_url . '" alt="' . JText::sprintf("Technorati") . '" />
        </a>';   
    }
/** Кнопка закладки в Twitter. **/ 
    private function getTwitterButton($title, $link){
        $img_url = MV_SOCIAL_BUTTONS_URL . "images/" . $this->params->get('style') . "/twitter.png";
return '<a rel="nofollow" href="http://twitter.com/?status=' . $link .'&amp;title=' . $title . '" title="' . JText::sprintf("Twitter") . '" target="_blank" >
        <img src="' . $img_url . '" alt="' . JText::sprintf("Twitter") . '" />
        </a>';   
    }
/** Кнопка закладки Linkedin. **/
    private function getLinkedInButton($title, $link){
        $img_url = MV_SOCIAL_BUTTONS_URL . "images/" . $this->params->get('style') . "/linkedin.png";       
        return '<a rel="nofollow" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=' . $link .'&amp;title=' . $title . '" title="' . JText::sprintf("LinkedIn") . '" target="_blank" >
        <img src="' . $img_url . '" alt="' . JText::sprintf("LinkedIn") . '" />
        </a>';   
    }
/** Кнопка закладки ВКонтакте. **/     
    private function getVkruButton($title, $link){       
        $img_url = MV_SOCIAL_BUTTONS_URL . "images/" . $this->params->get('style') . "/vkru.png";       
        return '<a rel="nofollow" href="http://vk.com/share.php?url=' . $link . '&amp;title=' . $title . '" title="' . JText::sprintf("VKонтакте") . '" target="_blank" >
        <img src="' . $img_url . '" alt="' . JText::sprintf("ВКонтакте") . '" />
        </a>';   
    }
/** Кнопка закладки Живой Журнал. **/    
    private function getLivejButton($title, $link){
        $img_url = MV_SOCIAL_BUTTONS_URL . "images/" . $this->params->get('style') . "/livej.png";      
        return '<a rel="nofollow" href="http://www.livejournal.com/update.bml?event=' . $link . '&amp;title=' . $title . '" title="' . JText::sprintf("LiveJournal") . '" target="_blank" >
        <img src="' . $img_url . '" alt="' . JText::sprintf("LiveJournal") . '" />
        </a>';
    }
/** Кнопка закладки Мой мир. **/     
    private function getMoymirButton($title, $link){
        $img_url = MV_SOCIAL_BUTTONS_URL . "images/" . $this->params->get('style') . "/moymir.png";  
        return '<a rel="nofollow" href="http://connect.mail.ru/share?share%20url=' . $link . '&amp;title=' . $title . '" title="' . JText::sprintf("Мой мир") . '" target="_blank" >
        <img src="' . $img_url . '" alt="' . JText::sprintf("Мой мир") . '" />
        </a>';
      }
/** Кнопка закладки Я.ру. **/   
    private function getYaruButton($title, $link){
        $img_url = MV_SOCIAL_BUTTONS_URL . "images/" . $this->params->get('style') . "/yaru.png";
        return '<a rel="nofollow" href="http://zakladki.yandex.ru/newlink.xml?url=' . $link . '&amp;title=' . $title . '" title="' . JText::sprintf("Я.ру") . '" target="_blank" >
        <img src="' . $img_url . '" alt="' . JText::sprintf("Я.ру") . '" />
        </a>';
        }
/** Кнопка закладки Одноклассники. **/      
    private function getOdnoklassnikiButton($title, $link){
        $img_url = MV_SOCIAL_BUTTONS_URL . "images/" . $this->params->get('style') . "/odnoklassniki.png";
        return '<a rel="nofollow" href="http://www.odnoklassniki.ru/dk?st.cmd=addShare&amp;st.%20surl=' . $link . '&amp;title=' . $title . '" title="' . JText::sprintf("Одноклассники") . '" target="_blank" >
        <img src="' . $img_url . '" alt="' . JText::sprintf("Одноклассники") . '" />
        </a>';
    }
	/** Кнопка закладки Liveinternet. **/      
    private function getLiveinternetButton($title, $link){
        $img_url = MV_SOCIAL_BUTTONS_URL . "images/" . $this->params->get('style') . "/liveinternet.png";        
        return '<a rel="nofollow" href="http://www.liveinternet.ru/journal%20post.php?action=n%20add&amp;cnurl=' . $link . '&amp;title=' . $title . '" title="' . JText::sprintf("Liveinternet") . '" target="_blank" >
        <img src="' . $img_url . '" alt="' . JText::sprintf("Liveinternet") . '" />
        </a>';  
    }
/** Кнопка закладки БобрДобр. **/      
    private function getBobrdobrButton($title, $link){
        $img_url = MV_SOCIAL_BUTTONS_URL . "images/" . $this->params->get('style') . "/bobrdobr.png";
        return '<a rel="nofollow" href="http://bobrdobr.ru/add.html?url=' . $link . '&amp;title=' . $title . '" title="' . JText::sprintf("БобрДобр") . '" target="_blank" >
        <img src="' . $img_url . '" alt="' . JText::sprintf("БобрДобр") . '" />
        </a>';
    }
}