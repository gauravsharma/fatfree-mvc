<?php

//! Base controller
class Controller
{

    protected
            $framework,
            $db;

    //! HTTP route pre-processor
    function beforeroute()
    {
        $f3 = $this->framework;
        $db = $this->db;
        
        /*
         * set an empty flash messages session variable, only if it
         * doesnot exists
         */
        if(FALSE === $this->framework->exists('SESSION.messages'))
        {
            $this->framework->set('SESSION.messages', array());
        }
    }

    //! HTTP route post-processor
    function afterroute()
    {
        // Render HTML layout
        echo Template::instance()->render('layout.html');
        
        /*
         * clear out the session flash message, shown only once and then cleared
         * from session
         */
        if($this->framework->exists('SESSION.messages'))
        {
            $this->framework->clear('SESSION.messages');
        }
    }

    //! Instantiate class
    function __construct()
    {
        $f3 = Base::instance();
        // Connect to the database
        $db = new DB\SQL(
                $f3->get('connproperties.dsn'),
                $f3->get('connproperties.username'),
                $f3->get('connproperties.password'),
                array(
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                ));

        // Save frequently used variables
        $this->framework = $f3;
        $this->db = $db;
    }

}