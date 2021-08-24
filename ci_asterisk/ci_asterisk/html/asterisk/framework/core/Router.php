<?php
class Router
{
    protected $routes;

    //$definitionsはApplicationクラスでRouterクラスのインスタンスを作成時に送られる配列
    public function __construct($definitions)
    {
        $this->routes = $this->compileRoutes($definitions);
    }

    public function compileRoutes($definitions)
    {
        $routes = array();

        foreach($definitions as $url => $params){
            //explodeで'/'を区切りにして配列にする
            //ltrimで先頭の'/'を取り除く
            $tokens = explode('/', ltrim($url, '/'));
            foreach($tokens as $i => $token){
                //strposは第一引数に第二引数の文字があった場所を返す。
                //この場合、先頭が':'なら以下の処理となる
                if(0 === strpos($token, ':')){
                    //substrで$tokenの１文字目を抜く
                    $name = substr($token, 1);
                    //正規表現にして$nameをキーにして名前をつける。
                    //$token = '(?P<' . $name . '>[a-zA-Z0-9].*)';
                    $token = '(?P<' . $name . '>[^/]+)';
                }
                //$tokensを':'等を取り除いた配列にして戻す
                $tokens[$i] = $token;
            }
            //implodeで$tokensの配列に'/'をはさんで文字列にする
            $pattern = '/' . implode('/', $tokens);
            //最終的に$definitions配列を$routesにしている
            $routes[$pattern] = $params;
        }

        return $routes;
    }

    public function resolve($path_info)
    {
        //$path_infoの先頭に'/'がついていないのなら'/'をつける
        if('/' !== substr($path_info, 0, 1)){
            $path_info = '/' . $path_info;
        }

        //conpileRoutesメソッドで作成した$routes配列を使う
        foreach($this->routes as $pattern => $params){
            
            if(preg_match('#^' . $pattern . '$#', $path_info, $matches)){
                //if(preg_match('#＾' . $pattern . '$#', $path_info, $matches)){
                //array_mergeで２つの配列を１つにする
                $params = array_merge($params, $matches);
                return $params;
            }

        }

        return false;
    }
}