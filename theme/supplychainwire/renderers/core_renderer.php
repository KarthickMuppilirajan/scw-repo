<?php
// This file is part of The Bootstrap Moodle theme
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot.'/local/scwgeneral/lib.php');
/**
 * Renderers to align Moodle's HTML with that expected by Bootstrap
 *
 * @package    theme_supplychainwire
 * @copyright  2012
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class theme_supplychainwire_core_renderer extends core_renderer {

    public function notification($message, $classes = 'notifyproblem') {
        /* $message = clean_text($message); */

        if ($classes == 'notifyproblem') {
            return html_writer::div($message, 'alert alert-danger');
        }
        if ($classes == 'notifywarning') {
            return html_writer::div($message, 'alert alert-warning');
        }
        if ($classes == 'notifysuccess') {
            return html_writer::div($message, 'alert alert-success');
        }
        if ($classes == 'notifymessage') {
            return html_writer::div($message, 'alert alert-info');
        }
        if ($classes == 'redirectmessage') {
            return html_writer::div($message, 'alert alert-block alert-info');
        }
        if ($classes == 'notifytiny') {
            // Not an appropriate semantic alert class!
            return $this->debug_listing($message);
        }
        return html_writer::div($message, $classes);
    }

    private function debug_listing($message) {
        $message = str_replace('<ul style', '<ul class="list-unstyled" style', $message);
        return html_writer::tag('pre', $message, array('class' => 'alert alert-info'));
    }

    public function navbar() {
        $items = $this->page->navbar->get_items();
        if (empty($items)) { // MDL-46107.
            return '';
        }
        $breadcrumbs = '';
        foreach ($items as $item) {
            $item->hideicon = true;
            $breadcrumbs .= '<li>'.$this->render($item).'</li>';
        }

        $title = html_writer::tag('span', get_string('pagepath'), array('class' => 'accesshide', 'id' => 'navbar-label'));
        return $title.html_writer::start_tag('nav',
            array('aria-labelledby' => 'navbar-label',
                'aria-label' => 'breadcrumb',
                'class' => 'breadcrumb-nav',
                'role' => 'navigation')).
            html_writer::tag('ul', "$breadcrumbs", array('class' => 'breadcrumb')).
            html_writer::end_tag('nav');
    }

    public function custom_menu($custommenuitems = '') {
        // The custom menu is always shown, even if no menu items
        // are configured in the global theme settings page.
        global $CFG;

        if (empty($custommenuitems) && !empty($CFG->custommenuitems)) { // MDL-45507.
            $custommenuitems = $CFG->custommenuitems;
        }
        $custommenu = new custom_menu($custommenuitems, current_language());
        return $this->render_custom_menu($custommenu);
    }

    protected function render_custom_menu(custom_menu $menu) {

        // Add the lang_menu to the left of the menu.
        $this->add_lang_menu($menu);

        $content = '<ul class="nav navbar-nav pull-right">';
        foreach ($menu->get_children() as $item) {
            $content .= $this->render_custom_menu_item($item, 1);
        }

        return $content.'</ul>';
    }

    protected function render_custom_menu_item(custom_menu_item $menunode, $level = 0, $direction = '' ) {
        static $submenucount = 0;

        if ($menunode->has_children()) {

            if ($level == 1) {
                $dropdowntype = 'dropdown';
            } else {
                $dropdowntype = 'dropdown-submenu';
            }

            $content = html_writer::start_tag('li', array('class' => $dropdowntype));
            // If the child has menus render it as a sub menu.
            $submenucount++;
            if ($menunode->get_url() !== null) {
                $url = $menunode->get_url();
            } else {
                $url = '#cm_submenu_'.$submenucount;
            }
            $linkattributes = array(
                'href' => $url,
                'class' => 'dropdown-toggle',
                'data-toggle' => 'dropdown',
                'title' => $menunode->get_title(),
            );
            $content .= html_writer::start_tag('a', $linkattributes);
            $content .= $menunode->get_text();
            if ($level == 1) {
                $content .= '<b class="caret"></b>';
            }
            $content .= '</a>';
            $content .= '<ul class="dropdown-menu '.$direction.'">';
            foreach ($menunode->get_children() as $menunode) {
                $content .= $this->render_custom_menu_item($menunode, 0);
            }
            $content .= '</ul>';
        } else {
            $content = '<li>';
            // The node doesn't have children so produce a final menuitem.
            $class = $menunode->get_title();
            if (preg_match("/^#+$/", $menunode->get_text())) {
                $content = '<li class="divider" role="presentation">';
            } else {
                $content = '<li>';
                // The node doesn't have children so produce a final menuitem.
                if ($menunode->get_url() !== null) {
                    $url = $menunode->get_url();
                } else {
                    $url = '#';
                }
                $content .= html_writer::link($url, $menunode->get_text(), array('class' => $class,
                    'title' => $menunode->get_title()));
            }
        }
        return $content;
    }

    /**
     * Adds a lang submenu in a custom_menu
     *
     * @return string The lang menu HTML or empty string
     */
    protected function add_lang_menu(custom_menu $menu, $force = false) {
        // TODO: eliminate this duplicated logic, it belongs in core, not
        // here. See MDL-39565.

        $haslangmenu = $this->lang_menu() != '';

        if ($force || ( !empty($this->page->layout_options['langmenu']) && $haslangmenu ) ) {
            $langs = get_string_manager()->get_list_of_translations();
            $strlang = get_string('language');
            $currentlang = current_language();
            if (isset($langs[$currentlang])) {
                $currentlang = $langs[$currentlang];
            } else {
                $currentlang = $strlang;
            }
            $this->language = $menu->add($currentlang, new moodle_url('#'), $strlang, 10000);
            foreach ($langs as $langtype => $langname) {
                $this->language->add($langname, new moodle_url($this->page->url, array('lang' => $langtype)), $langname);
            }
        }
    }

    /**
     * This code renders the navbar brand link displayed in the left navbar
     * on smaller screens.
     *
     * @return string HTML fragment
     */
    protected function navbar_brand() {
        global $CFG, $SITE;
        return html_writer::link($CFG->wwwroot, $SITE->shortname, array('class' => 'navbar-brand'));
    }

    /**
     * This code renders the navbar button to control the display of the custom menu
     * on smaller screens.
     *
     * Do not display the button if the menu is empty.
     *
     * @return string HTML fragment
     */
    protected function navbar_button() {
        global $CFG;

        if (empty($CFG->custommenuitems)) {
            return '';
        }

        $accessibility = html_writer::tag('span', get_string('togglenav', 'theme_supplychainwire'),
            array('class' => 'sr-only'));
        $iconbar = html_writer::tag('span', '', array('class' => 'icon-bar'));
        $button = html_writer::tag('button', $accessibility . "\n" . $iconbar . "\n" . $iconbar. "\n" . $iconbar,
            array('class' => 'navbar-toggle', 'data-toggle' => 'collapse', 'data-target' => '#moodle-navbar', 'type' => 'button'));
        return $button;
    }

    protected function render_tabtree(tabtree $tabtree) {
        if (empty($tabtree->subtree)) {
            return '';
        }
        $firstrow = $secondrow = '';
        foreach ($tabtree->subtree as $tab) {
            $firstrow .= $this->render($tab);
            if (($tab->selected || $tab->activated) && !empty($tab->subtree) && $tab->subtree !== array()) {
                $secondrow = $this->tabtree($tab->subtree);
            }
        }
        return html_writer::tag('ul', $firstrow, array('class' => 'nav nav-tabs')) . $secondrow;
    }

    protected function render_tabobject(tabobject $tab) {
        if ($tab->selected or $tab->activated) {
            return html_writer::tag('li', html_writer::tag('a', $tab->text), array('class' => 'active'));
        } else if ($tab->inactive) {
            return html_writer::tag('li', html_writer::tag('a', $tab->text), array('class' => 'disabled'));
        } else {
            if (!($tab->link instanceof moodle_url)) {
                // Backward compatibility when link was passed as quoted string.
                $link = "<a href=\"$tab->link\" title=\"$tab->title\">$tab->text</a>";
            } else {
                $link = html_writer::link($tab->link, $tab->text, array('title' => $tab->title));
            }
            return html_writer::tag('li', $link);
        }
    }

    public function box($contents, $classes = 'generalbox', $id = null, $attributes = array()) {
        if (isset($attributes['data-rel']) && $attributes['data-rel'] === 'fatalerror') {
            return html_writer::div($contents, 'alert alert-danger', $attributes);
        }
        return parent::box($contents, $classes, $id, $attributes);
    }
	
	public function user_menu($user = null, $withlinks = null) {
        global $USER, $CFG, $OUTPUT,$DB;
        require_once($CFG->dirroot . '/user/lib.php');
		
        
        $dlink = new moodle_url("/my");
        $plink = new moodle_url("/user/editprofile.php", array());
        $lo = new moodle_url('/login/logout.php', array('sesskey' => sesskey()));
		$mylink = new moodle_url('/local/mylinks');
		$deactivate = new moodle_url('/login/deactivate.php');
		$mailbox = new moodle_url('/local/scwmail');
		$dashboard = get_string('myhome');
		$profile = 'Edit Profile';
		$logout = get_string('logout');
		$mylinks = get_string('mylinks','theme_supplychainwire');
		$mymail= get_string('mailbox','theme_supplychainwire');
		$curr_user = new stdClass;
		$curr_user = $DB->get_record('user', array('id'=>$USER->id));
		$uname = ucfirst($curr_user->firstname)." ".ucfirst($curr_user->lastname);
		
		$mail_count=theme_supplychainwire_get_inbox_count($USER->id,'inbox');
		if($mail_count>0){ 
		 $mail_cir='<span class="circle_count">'.$mail_count.'</span>';
		}else{
			$mail_cir="";
		}
		$connect_count= theme_supplychainwire_get_pending_connect($USER->id);
		if($connect_count>0){
			$connection_cir='<span class="circle_count">'.$connect_count.'</span>';			
		}else{
			$connection_cir="";
		}
		$cond = (local_scwgeneral_check_scwsales() || local_scwgeneral_check_scwadmin());
        $dasstr = ($cond) ? '<li><a href="'.$dlink.'" id="prodashboard">'.$dashboard.'</a></li>':'';
        $deacstr = (!$cond) ? '<li><a id="prologout" href="'.$deactivate.'">Deactivate account</a></li>':'';
		$mylinkstr = (!$cond) ? '<li><a id="promylink" href="'.$mylink.'">'.$mylinks.' '.$connection_cir.'</a></li>':'';
		$mailstr = (!$cond) ? '<li><a id="promailbox" href="'.$mailbox.'">'.$mymail.' '.$mail_cir.'</a></li>':'';
		
        $content = '<li class="dropdown no-divider">
        <a class="dropdown-toggle" id="prodrpdwnlink"
        data-toggle="dropdown"
        href="javascript:void(0);">
        '.$uname.'
        <i class="fa fa-chevron-down"></i><span class="caretup"></span>
        </a>
        <ul class="dropdown-menu" id="prodrpdwn">
        '.$dasstr.'
        <li><a id="proprofilelink" href="'.$plink.'">'.$profile.'</a></li>
		'.$mylinkstr.'
		'.$mailstr.'
		'.$deacstr.'
        <li><a id="prologout" href="'.$lo.'">'.$logout.'</a></li>
        </ul>
        </li>
		<li>
		'.$OUTPUT->user_picture($curr_user, array('size'=>50, 'alttext'=>false,'link'=>false,'class'=>'img-responsive img-circle profile-img')).'
		</li>';

        return $content;
    }


	
	public function scw_top_banners(){
        global $CFG, $PAGE;
        $ptype = $PAGE->pagetype;
		
		$slidehead = '<div class="main-banner">'."\n";
        $slidehead .= '<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">'."\n";
  
       $slidefoot = "\n".'</div>'."\n";
       $slidefoot .= '</div>'."\n";
		
		$itemhead = "\n".'<div class="carousel-inner" role="listbox">'."\n";
		$itemfoot = "\n".'</div>'."\n";
		
		$carouselhd = "\n".'<ol class="carousel-indicators">'."\n";
		$carouselft = '</ol>'."\n";
		$carouselcont = '';
		

		require_once($CFG->dirroot.'/local/scwbanner/lib.php');
		$banners = local_scwbanner_get_banners();
		$topbanners = isset($banners[$ptype]['top']) ? $banners[$ptype]['top'] : array();
		$count = 0; 
		$carouselcont = '';
		$itmcnt = '';
		
		if(empty($topbanners)){
			$topbanners[] = array("imgurl" => $CFG->wwwroot.'/theme/supplychainwire/pix/default-imgs/top.jpg',
			        "brurl" => "javascript:void(0);",
					"bcpn" => "Banner position available."
					);
		}else{
			$nobanner = get_config('local_scwbanner', 'top_no_banner');
			$topbanners1 = $topbanners;
			$topbanners = array_slice($topbanners1,0,$nobanner);
		}
		
		foreach($topbanners as $topbanner){
			$clact = ($count=="0") ? ' class="active" ':' ';
			$carouselcont .= '<li data-target="#carousel-example-generic" data-slide-to="'.$count.'" '.$clact.'></li>'."\n";
			
			$itact = ($count=="0") ? ' active':'';
			$itmcpt = "\n".'<div class="carousel-caption">'.$topbanner["bcpn"].'</div>';
			$itmcnt .= "\n".'<div class="item'.$itact.'">'."\n";
            $itmcnt .= '<a href="'.$topbanner["brurl"].'" target="_blank"><img src="'.$topbanner["imgurl"].'" alt="'.$topbanner["bcpn"].'"></a>'.$itmcpt;
			//$itmcnt .= '<img src="'.$topbanner["imgurl"].'" alt="'.$topbanner["bcpn"].'">'.$itmcpt;
			$itmcnt .= "\n".'</div>'."\n";
		   $count++;
		}
		$carousel = $carouselhd.$carouselcont.$carouselft;
		if ($count<=1) { 
		   $carousel = '';
		}
		$slideritems = $itemhead.$itmcnt.$itemfoot;
		
		$topslider = $slidehead.$carousel.$slideritems.$slidefoot;
		
		return $topslider;
	}
	
     protected function render_paging_bar(paging_bar $pagingbar) {
        // Any more than 10 is not usable and causes wierd wrapping of the pagination in this theme.
        $pagingbar->maxdisplay = 10;
        return $this->render_from_template('core/paging_bar', $pagingbar->export_for_template($this));
    }

    public function scw_left_right_banner($pos='right1', $bclass='rhtbanner1-blk'){
		global $CFG, $PAGE;
        $ptype = $PAGE->pagetype;
		
		require_once($CFG->dirroot.'/local/scwbanner/lib.php');
		$banners = local_scwbanner_get_banners();
		$lright1banner = isset($banners[$ptype][$pos]) ? $banners[$ptype][$pos] : array();
		$count = 0; 
		$carouselcont = '';
		$itmcnt = '';
		
		if(empty($lright1banner)){
			$lright1banner[] = array("imgurl" => $CFG->wwwroot.'/theme/supplychainwire/pix/default-imgs/'.$pos.'.jpg',
			        "brurl" => "javascript:void(0);",
					"bcpn" => ""
					);
		}else{
			$nobanner = 1;
			$lright1banner1 = $lright1banner;
			$lright1banner = array_slice($lright1banner1,0,$nobanner);
		}
		$banner = reset($lright1banner);
		$byes = !empty($banner["bcpn"]) ? true : false;
		$barr = array("bannerclass" => $bclass, "brurl" => $banner["brurl"] , "imgurl" => $banner["imgurl"], "caption" => $banner["bcpn"], "byes" => $byes);
		
		return $this->render_from_template('local_scwbanner/banner', $barr);
		
	}
	
}
