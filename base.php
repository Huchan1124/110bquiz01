<?php


class DB{
    private $dsn="mysql:host=localhost;charset=utf8;dbname=db_story";
    private $root='root';
    private $password='12345';
    private $table;
    private $pdo;

    public function __construct($table){
        $this->table=$table;
        $this->pdo=new PDO($this->dsn,$this->root,$this->password);
    }

    public function all(...$arg){
        $sql="select * from $this->table ";
        // $arg=[]  or [陣列],[SQL字串],[陣列,SQL字串],

        if(isset($arg[0])){
            if(is_array($arg[0])){
                    echo "處理陣列";
            }else{
                //當它是字串
                $sql=$sql . $arg[0];
            }

            if(isset($arg[1])){
                //當它是字串
                $sql=$sql . $arg[1];
            }

        }

        //echo $sql;
        return $this->pdo->query($sql)->fetchAll();

    }
}

$User=new DB("user");


echo "<pre>";
print_r($User->all());
echo "</pre>";

echo "<pre>";
print_r($User->all(" where name='amy' "));
echo "</pre>";

echo "<pre>";
print_r($User->all(" where `visible`='Y' " , " order by `id` DESC"));
echo "</pre>";




?>