<?php
    abstract class Model{
        protected $dbh;
        protected $stmt;

        /**
         * Model constructor.
         * Connect to db.
         */
        public function __construct()
        {
            $this->dbh = new PDO("mysql:host=" .DB_HOST. ";dbname=" .DB_NAME, DB_USER, DB_PASS);
        }

        /**
         * Prepared the query.
         *
         * @param $query
         */
        public function query($query)
        {
            $this->stmt = $this->dbh->prepare($query);
        }

        /**
         * Bind the prep statement
         *
         * @param $param
         * @param $value
         * @param null $type
         */
        public function bind($param, $value, $type = null)
        {
            if(is_null($type)){
                switch (true){
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                }
            }

            $this->stmt->bindValue($param, $value, $type);
        }

        public function execute()
        {
            $this->stmt->execute();
        }

        public function resultSet()
        {
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function lastInsertId()
        {
            return $this->dbh->lastInsertId();
        }

        public function single()
        {
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function affectedRows()
        {
            return $this->stmt->rowCount();
        }
    }