<?php
/*
 * Copyright (2017) SoCal Bioinformatics Inc. All rights reserved.
 * This script is the confidential and proprietary product
 * of SoCal Bioinformatics Inc. Any Unauthorized reproduction or
 * transfer of the contents herein is strictly prohibited.
 *
 * AUTH: Jeff Jones | SoCal Bioinformatics Inc.
 * EMAIL: jeff@socalbioinformatics.com
 * DATE: 2018.01.23
 * OWNER: SoCal Bioinformatics Inc.
 * PROJECT: midnightbaseball.com
 * DESC:
 */
namespace ProxyMVC\User;

use ProxyHTML\Authentication\Invites;

class UserInvite extends Invites
{

    private $email_from_name;

    private $email_from;

    private $email_to_name;

    private $email_to;

    private $server_name;

    private $str_random;

    public function __construct($server = false, $schema = false)
    {
        parent::__construct($server, $schema);
        
        $ini = parse_ini_file(get_include_path() . 'ini/config.ini');
        
        $this->server_name = $ini['server_name'];
        
        $this->setSender($ini['site_email'], $ini['site_name']);
    }

    public function setRecipent($email, $name = NULL)
    {
        if (is_false($this->str_random = $this->createNewInvite($email)))
            return false;
        
        $this->email_to_name = $name;
        $this->email_to = $email;
    }

    protected function setSender($email, $name = NULL)
    {
        $this->email_from_name = $name;
        $this->email_from = $email;
    }

    public function sendInvite()
    {
        
        // Create the Transport via Sendmail
        $transport = new \Swift_SendmailTransport('/usr/sbin/sendmail -bs');
        
        // Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($transport);
        
        // Create a message
        $message = (new \Swift_Message($this->getMessage()))->setFrom([
            $this->email_from => $this->email_from_name
        ])
            ->setTo([
            $this->email_to
        ])
            ->setBody($this->getContents());
        
        $message->setContentType("text/html");
        
        // Send the message
        $result = $mailer->send($message);
    }

    private function getMessage()
    {
        return 'Invite to User on ' . $this->email_from_name;
    }

    private function getContents()
    {
        $link = 'http://' . $this->server_name . '/?page=UserAccept&id=' . urlencode($this->str_random);
        $image = 'http://' . $this->server_name . '/media/yoursite_logo.png';
        $html = file_get_contents("../src/Layouts/User/Invite.htm");
        $html = preg_replace("/#LINK/", $link, $html);
        $html = preg_replace("/#IMAGE/", $image, $html);
        
        return $html;
    }
}
?>