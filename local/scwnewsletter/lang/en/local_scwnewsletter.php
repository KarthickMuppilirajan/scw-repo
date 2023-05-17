<?php
$string['pluginname'] = 'SCW Newsletter';
$string['newsletter'] = 'NewsLetter';
$string['subscribe'] = 'SUBSCRIBE';
$string['email'] = 'Email';
$string['scwnewsletter:addnewsletter'] = 'Add Newsletter';
$string['scwnewsletter:editnewsletter'] = 'Edit Newsletter';
$string['scwnewsletter:deletenewsletter'] = 'Delete Newsletter';
$string['scwnewsletter:viewnewsletter'] = 'View Newsletters';
$string['viewaccessdenied'] = 'You Don\'t have view access for newsletter admin section.';
$string['editaccessdenied'] = 'You Don\'t have edit newsletter access.';
$string['addaccessdenied'] = 'You Don\'t have add newsletter access.';
$string['validate_email']="Please enter valid email address";
$string['require_email']="Please enter an email address";
$string['require_name']="Please enter your name";
$string['subscriber_name']="Name";
$string['title']="Title";
$string['user_type']="User Type";
$string['status']="Status";
$string['action']="Action";
$string['validate_title']="Please enter Title";
$string['search']="Search";
$string['send_newsletter']="Send Newsletter";
$string['select_usertype']="Please select any user type";
$string['message']="Message";
$string['validate_message']="Please enter message";
$string['send']="Send";
$string['cancel']="Cancel";
$string['publish']="Publish";
$string['date']="Date";
$string['created_by']="Created By";
$string['alphanumeric_err']="Please enter numbers and letters only";
$string['managenewsletter']="Manage newsletters";
$string['managesubscribers']="Manage Subscribers";
$string['preview']="Preview";

$string['email_template'] = '
<div style="background-color:#F0F0F0">
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
          <tr>
            <td align="left" valign="top" bgcolor="#ffffff"><table width="100%" border="0" cellspacing="10" cellpadding="10">
              <tbody>
                <tr>
                  <td><a href="{$a->siteurl}"><img border="0" src="http://4blabs.com/scw/email-template/images/supplychainwire-logo.png" width="288" height="44" alt="Supply Chain Wire" /></a></td>
                </tr>
              </tbody>
            </table></td>
          </tr>
           <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
            <td align="left" valign="top" bgcolor="#ffffff"><table width="100%" border="0" cellspacing="10" cellpadding="10">
              <tbody>
      
		  <tr><td>
          <p style="font-family: arial;font-size:18px;font-weight:normal;color:#8c181d;padding:0;margin:0 0 0px 0;width:100%;line-height:16px;">Hi {$a->user},</p>
		  {$a->message}
          </td></tr>
</tbody></table></td></tr>
<tr><td>&nbsp;</td></tr>
		  <tr>
            <td align="left" valign="top" bgcolor="#313a3e"><table width="100%" border="0" cellspacing="10" cellpadding="10">
              <tbody>
                <tr>
                  <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                      <tr>
                        <td align="center" valign="middle"><p style="font-family: arial;font-size:12px;font-weight:bold;color:#ffffff;padding:0;margin:0 0 12px 0;width:100%;line-height:16px;"><a href="#" style="font-weight:bold;color:#ffffff;text-decoration: none;">Privacy Policy</a>  |  <a href="#" style="font-weight:bold;color:#ffffff;text-decoration: none;">Disclaimer</a>  |  <a href="#" style="font-weight:bold;color:#ffffff;text-decoration: none;">Terms of Service</a>  |  <a href="#" style="font-weight:bold;color:#ffffff;text-decoration: none;">Contact</a></p></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody>
                                  <tr>
                                    <td align="left" valign="middle"><p style="font-family: arial;font-size:11px;font-weight:normal;color:#95989a;padding:0;margin:0 0 0px 0;width:100%;line-height:16px;">© 2017 Supply Chain Wire. All rights reserved.</p></td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="middle"><p style="font-family: arial;font-size:11px;font-weight:normal;color:#95989a;padding:0;margin:0 0 0px 0;width:100%;line-height:16px;">This is a marketing email from Supply Chain Wire.</p> </td>
                                  </tr>
                                </tbody>
                              </table></td>
								<!--<td width="27%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody>
                                  <tr>
                                    <td align="center" valign="middle"><a href="#"><img border="0" src="http://4blabs.com/scw/email-template/images/facebook.png" width="23" height="23" alt="Facebook" /></a></td>
                                    <td align="center" valign="middle"><a href="#"><img border="0" src="http://4blabs.com/scw/email-template/images/twitter.png" width="23" height="23" alt="Twitter" /></a></td>
                                    <td align="center" valign="middle"><a href="#"><img border="0" src="http://4blabs.com/scw/email-template/images/linkedin.png" width="23" height="23" alt="Linked In" /></a></td>
                                    <td align="center" valign="middle"><a href="#"><img border="0" src="http://4blabs.com/scw/email-template/images/gplus.png" width="23" height="23" alt="Gplus" /></a></td>
                                    <td align="center" valign="middle"><a href="#"><img border="0" src="http://4blabs.com/scw/email-template/images/youtube.png" width="23" height="23" alt="Youtube" /></a></td>
                                  </tr>
                                </tbody>
                              </table></td>-->
							  <td width="27%" align="right" valign="top"><table width="40%" border="0" cellspacing="0" cellpadding="0">
                                <tbody>
                                  <tr>
                                   
                                    <td align="center" valign="middle"><a href="https://twitter.com/supplychainwire" target="_blank"><img border="0" src="http://4blabs.com/scw/email-template/images/twitter.png" width="23" height="23" alt="Twitter" /></a></td>
                                    <td align="center" valign="middle"><a href="https://www.linkedin.com/in/supplychainwire" target="_blank"><img border="0" src="http://4blabs.com/scw/email-template/images/linkedin.png" width="23" height="23" alt="Linked In" /></a></td>
                                   
                                  </tr>
                                </tbody>
                              </table></td>								  							 
                            </tr>
                          </tbody>
                        </table></td>
                      </tr>
                    </tbody>
                  </table></td>
                </tr>
              </tbody>
            </table></td>
          </tr>          
                    <tr>
            <td><p style="font-family: arial;font-size:11px;font-weight:normal;color:#a0a2a3;padding:0;margin:4px 0 0px 0;width:100%;line-height:16px;"><a href="{$a->siteurl}/local/scwnewsletter/unsubscribe.php?user_id={$a->user_id}&user_type={$a->user_type}" style="font-weight:normal;color:#a0a2a3;">Click here</a> to unsubscribe, or send us an unsubscribe request to the address above.</p></td>
          </tr>
          <tr>
            <td><p style="font-family: arial;font-size:11px;font-weight:normal;color:#a0a2a3;padding:0;margin:0 0 0px 0;width:100%;line-height:16px;">If you have a privacy-related complaint, send it to: <a href="#" style="font-weight:normal;color:#a0a2a3;">privacy@supplychainwire.com</a></p></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
  </tbody>
</table>
</div>
';
$string['email_template_view'] = '
<div style="background-color:#F0F0F0">
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
          <tr>
            <td align="left" valign="top" bgcolor="#ffffff"><table width="100%" border="0" cellspacing="10" cellpadding="10">
              <tbody>
                <tr>
                  <td><a href="#"><img border="0" src="http://4blabs.com/scw/email-template/images/supplychainwire-logo.png" width="288" height="44" alt="Supply Chain Wire" /></a></td>
                </tr>
              </tbody>
            </table></td>
          </tr>
           <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
            <td align="left" valign="top" bgcolor="#ffffff"><table width="100%" border="0" cellspacing="10" cellpadding="10">
              <tbody>
      
		  <tr><td>
		  {$a->message}
          </td></tr>
</tbody></table></td></tr>
<tr><td>&nbsp;</td></tr>
		  <tr>
            <td align="left" valign="top" bgcolor="#313a3e"><table width="100%" border="0" cellspacing="10" cellpadding="10">
              <tbody>
                <tr>
                  <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                      <tr>
                        <td align="center" valign="middle"><p style="font-family: arial;font-size:12px;font-weight:bold;color:#ffffff;padding:0;margin:0 0 12px 0;width:100%;line-height:16px;"><a href="#" style="font-weight:bold;color:#ffffff;text-decoration: none;">Privacy Policy</a>  |  <a href="#" style="font-weight:bold;color:#ffffff;text-decoration: none;">Disclaimer</a>  |  <a href="#" style="font-weight:bold;color:#ffffff;text-decoration: none;">Terms of Service</a>  |  <a href="#" style="font-weight:bold;color:#ffffff;text-decoration: none;">Contact</a></p></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody>
                                  <tr>
                                    <td align="left" valign="middle"><p style="font-family: arial;font-size:11px;font-weight:normal;color:#95989a;padding:0;margin:0 0 0px 0;width:100%;line-height:16px;">© 2017 Supply Chain Wire. All rights reserved.</p></td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="middle"><p style="font-family: arial;font-size:11px;font-weight:normal;color:#95989a;padding:0;margin:0 0 0px 0;width:100%;line-height:16px;">This is a marketing email from Supply Chain Wire.</p> </td>
                                  </tr>
                                </tbody>
                              </table></td>
                              <!--<td width="27%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody>
                                  <tr>
                                    <td align="center" valign="middle"><a href="#"><img border="0" src="http://4blabs.com/scw/email-template/images/facebook.png" width="23" height="23" alt="Facebook" /></a></td>
                                    <td align="center" valign="middle"><a href="#"><img border="0" src="http://4blabs.com/scw/email-template/images/twitter.png" width="23" height="23" alt="Twitter" /></a></td>
                                    <td align="center" valign="middle"><a href="#"><img border="0" src="http://4blabs.com/scw/email-template/images/linkedin.png" width="23" height="23" alt="Linked In" /></a></td>
                                    <td align="center" valign="middle"><a href="#"><img border="0" src="http://4blabs.com/scw/email-template/images/gplus.png" width="23" height="23" alt="Gplus" /></a></td>
                                    <td align="center" valign="middle"><a href="#"><img border="0" src="http://4blabs.com/scw/email-template/images/youtube.png" width="23" height="23" alt="Youtube" /></a></td>
                                  </tr>
                                </tbody>
                              </table></td>-->
							  <td width="27%" align="right" valign="top"><table width="40%" border="0" cellspacing="0" cellpadding="0">
                                <tbody>
                                  <tr>
                                   
                                    <td align="center" valign="middle"><a href="https://twitter.com/supplychainwire" target="_blank"><img border="0" src="http://4blabs.com/scw/email-template/images/twitter.png" width="23" height="23" alt="Twitter" /></a></td>
                                    <td align="center" valign="middle"><a href="https://www.linkedin.com/in/supplychainwire" target="_blank"><img border="0" src="http://4blabs.com/scw/email-template/images/linkedin.png" width="23" height="23" alt="Linked In" /></a></td>
                                   
                                  </tr>
                                </tbody>
                              </table></td>							  
                            </tr>
                          </tbody>
                        </table></td>
                      </tr>
                    </tbody>
                  </table></td>
                </tr>
              </tbody>
            </table></td>
          </tr>          
                    <tr>
            <td><p style="font-family: arial;font-size:11px;font-weight:normal;color:#a0a2a3;padding:0;margin:4px 0 0px 0;width:100%;line-height:16px;"><a href="#" style="font-weight:normal;color:#a0a2a3;">Click here</a> to unsubscribe, or send us an unsubscribe request to the address above.</p></td>
          </tr>
          <tr>
            <td><p style="font-family: arial;font-size:11px;font-weight:normal;color:#a0a2a3;padding:0;margin:0 0 0px 0;width:100%;line-height:16px;">If you have a privacy-related complaint, send it to: <a href="#" style="font-weight:normal;color:#a0a2a3;">privacy@supplychainwire.com</a></p></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
  </tbody>
</table>
</div>
';


?> 

