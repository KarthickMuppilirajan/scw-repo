<?php
$string['pluginname'] = 'SCW Mylinks';
$string['mylinks'] = 'My Links';
$string['connected'] = 'Connected';
$string['requestsent'] = 'Request sent';
$string['confirm'] = 'Confirm';
$string['noconnections'] = "No connections yet";
$string['connect_mail_subject'] = '{$a->firstname} sent you connection request';
//$string['connect_mail_content_inbox'] = '<p>Hello {$a->receiveuser}
			//{$a->sentuser} would like to establish a connection link with you. <br>
			//Profile : <a href="{$a->profile_link}">Click here</a></p>';
$string['connect_mail_content_inbox'] = 'Hello {$a->receiveuser},
			{$a->sentuser} would like to establish a connection link with you. <br>
			Click <a href="{$a->profile_link}">Profile</a> to view and confirm connect<br>';  
			                                  						
$string['connect_mail_content'] = '
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
          <p style="font-family: arial;font-size:18px;font-weight:normal;color:#8c181d;padding:0;margin:0 0 0px 0;width:100%;line-height:16px;"> Hello {$a->receiveuser},</p>
		  <br>
			{$a->sentuser} would like to establish a connection link with you. <br>
			Click <a href="{$a->profile_link}">Profile</a> to view and confirm connect<br>
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
            <td><p style="font-family: arial;font-size:11px;font-weight:normal;color:#a0a2a3;padding:0;margin:4px 0 0px 0;width:100%;line-height:16px;"><a href="{$a->siteurl}/local/scwnewsletter/unsubscribe.php?user_id={$a->user_id}" style="font-weight:normal;color:#a0a2a3;">Click here</a> to unsubscribe, or send us an unsubscribe request to the address above.</p></td>
          </tr>
          <tr>
            <td><p style="font-family: arial;font-size:11px;font-weight:normal;color:#a0a2a3;padding:0;margin:0 0 0px 0;width:100%;line-height:16px;">If you have a privacy-related complaint, send it to: <a href="#" style="font-weight:normal;color:#a0a2a3;">privacy@supplychainwire.com</a></p></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
  </tbody>
</table>
</div>';									
$string['blocked'] = "Blocked";
$string['unblock'] = "Unblock";
?> 