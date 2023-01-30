<?php

declare (strict_types=1);

/**
 * Hämtar en lista med alla uppgifter och tillhörande aktiviteter 
 * Beroende på indata returneras en sida eller ett datumintervall
 * @param Route $route indata med information om vad som ska hämtas
 * @return Response
 */
function tasklists(Route $route): Response {
    try {
        if (count($route->getParams()) === 1 && $route->getMethod() === RequestMethod::GET) {
            return hamtaSida((int) $route->getParams()[0]);
        }
        if (count($route->getParams()) === 2 && $route->getMethod() === RequestMethod::GET) {
            return hamtaDatum(new DateTimeImmutable($route->getParams()[0]), new DateTimeImmutable($route->getParams()[1]));
        }
    } catch (Exception $exc) {
        return new Response($exc->getMessage(), 400);
    }

    return new Response("Okänt anrop", 400);
}

/**
 * Läs av rutt-information och anropa funktion baserat på angiven rutt
 * @param Route $route Rutt-information
 * @param array $postData Indata för behandling i angiven rutt
 * @return Response
 */
function tasks(Route $route, array $postData): Response {
    try {
        if (count($route->getParams()) === 1 && $route->getMethod() === RequestMethod::GET) {
            return hamtaEnskildUppgift((int) $route->getParams()[0]);
        }
        if (count($route->getParams()) === 0 && $route->getMethod() === RequestMethod::POST) {
            return sparaNyUppgift($postData);
        }
        if (count($route->getParams()) === 1 && $route->getMethod() === RequestMethod::PUT) {
            return uppdateraUppgift((int) $route->getParams()[0], $postData);
        }
        if (count($route->getParams()) === 1 && $route->getMethod() === RequestMethod::DELETE) {
            return raderaUppgift((int) $route->getParams()[0]);
        }
    } catch (Exception $exc) {
        return new Response($exc->getMessage(), 400);
    }

    return new Response("Okänt anrop", 400);
}

/**
 * Hämtar alla uppgifter för en angiven sida
 * @param int $sida
 * @return Response
 */
function hamtaSida(int $sida): Response {
    return new Response("Hämta alla tasks sida $sida", 200);
}

/**
 * Hämtar alla poster mellan angivna datum
 * @param DateTimeInterface $from
 * @param DateTimeInterface $tom
 * @return Response
 */
function hamtaDatum(DateTimeInterface $from, DateTimeInterface $tom): Response {
    return new Response("Hämta alla tasks mellan " . $from->format("Y-m-d") . " och " . $tom->format("Y-m-d"), 200);
}

/**
 * Hämtar en enskild uppgiftspost
 * @param int $id Id för post som ska hämtas
 * @return Response
 */
function hamtaEnskildUppgift(int $id): Response {
    $kollatID = filter_var ($id, FILTER_VALIDATE_INT);
    if(!$kollatID || $kollatID < 1){
        $out = new stdClass();
        $out->error = ["felaktig indata", "$id är inget giltigt heltal"];
        return new Response ($out, 400);
    }
    //koppla mot databas
    $db= connectDb();
    //förbered pch exekvera sql
    $stmt=$db->prepare("SELECT t.id, kategoriId, datum, tid, beskrivning, kategori "
    ."FROM uppgifter t "
    ." INNER JOIN kategorier a ON kategoriId=a.id "
    . "WHERE t.id=:id ");

    $stmt->execute(["id"=>$kollatID]);
    //returnera svaret
    if($row=$stmt->fetch()){
        $out= new stdClass;
        $out->id=$row["id"];
        $out->activity=$row["kategoriId"];
        $out->date=$row["datum"];
        $out->time=$row["tid"];
        $out->description=$row["beskrivning"];
        $out->activity=$row["kategori"];

        return new Response ($out);
    }else{
        $out=new stdClass();
        $out->error=["fel vid hämtning"];
        return new Response ($out, 400);
    }

}

/**
 * Sparar en ny uppgiftspost
 * @param array $postData indata för uppgiften
 * @return Response
 */
function sparaNyUppgift(array $postData): Response {
    return new Response("Sparar ny task", 200);
}

/**
 * Uppdaterar en angiven uppgiftspost med ny information 
 * @param int $id id för posten som ska uppdateras
 * @param array $postData ny data att sparas
 * @return Response
 */
function uppdateraUppgift(int $id, array $postData): Response {
    return new Response("Uppdaterar task $id", 200);
}

/**
 * Raderar en uppgiftspost
 * @param int $id Id för posten som ska raderas
 * @return Response
 */
function raderaUppgift(int $id): Response {
    return new Response("Raderar task $id", 200);
}
