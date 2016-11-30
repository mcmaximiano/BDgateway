<html>
    <body>
<?php
    try
    {
    	$host = "db.ist.utl.pt";
        $user ="ist80975";
        $password = "kiie4146";
        $dbname = $user;
        
        $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $sql = "SELECT morada, codigo, SUM(montanteTotal) as montantePago
FROM (SELECT morada, codigo, tarifa*Dias as montanteTotal
FROM (SELECT DATEDIFF(data_fim, data_inicio) AS Dias, numero FROM oferta natural join aluga) dias natural join (
SELECT * 
FROM (SELECT morada, codigo, tarifa, numero, data_inicio, data_fim
FROM oferta NATURAL JOIN espaco NATURAL JOIN aluga 
UNION 
SELECT morada, codigo_espaco as codigo, tarifa, numero, data_inicio, data_fim
FROM oferta NATURAL JOIN posto NATURAL JOIN aluga) AllRents
WHERE YEAR(data_inicio)=2016) blah ) final
GROUP BY final.morada, final.codigo;";
    
        $result = $db->query($sql);
    
        echo("<table border=\"2\">\n");
        echo("<tr><td>Morada</td><td>Codigo</td><td>Montante Total</td></tr>\n");
        foreach($result as $row)
        {
            echo("<tr><td>");
            echo($row['morada']);
            echo("</td><td>");
            echo($row['codigo']);
            echo("</td><td>");
            echo($row['montantePago']);
            echo("</td></tr>\n");
        }
        echo("</table>\n");
    
        $db = null;
    }
    catch (PDOException $e)
    {
        echo("<p>ERROR: {$e->getMessage()}</p>");
    }
?>
    </body>
</html>
