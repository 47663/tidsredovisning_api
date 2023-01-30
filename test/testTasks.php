<?php

declare (strict_types=1);
require_once __DIR__.'/../src/tasks.php';
/**
 * Funktion för att testa alla aktiviteter
 * @return string html-sträng med resultatet av alla tester
 */
function allaTaskTester(): string {
// Kom ihåg att lägga till alla testfunktioner
    $retur = "<h1>Testar alla uppgiftsfunktioner</h1>";
    $retur .= test_HamtaEnUppgift();
    $retur .= test_HamtaUppgifterSida();
    $retur .= test_RaderaUppgift();
    $retur .= test_SparaUppgift();
    $retur .= test_UppdateraUppgifter();
    return $retur;
}

/**
 * Funktion för att testa en enskild funktion
 * @param string $funktion namnet (utan test_) på funktionen som ska testas
 * @return string html-sträng med information om resultatet av testen eller att testet inte fanns
 */
function testTaskFunction(string $funktion): string {
    if (function_exists("test_$funktion")) {
        return call_user_func("test_$funktion");
    } else {
        return "<p class='error'>Funktionen $funktion kan inte testas.</p>";
    }
}

/**
 * Tester för funktionen hämta uppgifter för ett angivet sidnummer
 * @return string html-sträng med alla resultat för testerna 
 */
function test_HamtaUppgifterSida(): string {
    $retur = "<h2>test_HamtaUppgifterSida</h2>";
    $retur .= "<p class='ok'>Testar hämta alla uppgifter på en sida</p>";
    return $retur;
}

/**
 * Test för funktionen hämta uppgifter mellan angivna datum
 * @return string html-sträng med alla resultat för testerna
 */
function test_HamtaAllaUppgifterDatum(): string {
    $retur = "<h2>test_HamtaAllaUppgifterDatum</h2>";
    $retur .= "<p class='ok'>Testar hämta alla uppgifter mellan två datum</p>";
    return $retur;
}

/**
 * Test av funktionen hämta enskild uppgift
 * @return string html-sträng med alla resultat för testerna
 */
function test_HamtaEnUppgift(): string {
    $retur = "<h2>test_HamtaEnUppgift</h2>";
    try {
        // Testa lägga dit tal
        $svar= hamtaEnskildUppgift(-1);
        if ($svar->getStatus()===400){
            $retur.= "<p class='ok'>Hämta enskild med negativt tal ger förväntat svar 400</p>";
        } else {
            $retur.= "<p class='error'>Hämta enskild med negativt tal ger {$svar->getStatus()} "."inte förväntat svar 400</p>";
        }
        // Testa för stort tal
        $svar= hamtaEnskildUppgift(100);
        if ($svar->getStatus()===400){
            $retur.= "<p class='ok'>Hämta enskild med stort tal ger förväntat svar 400</p>";
        } else {
            $retur.= "<p class='error'>Hämta enskild med stort (100) tal ger {$svar->getStatus()} "."inte förväntat svar 400</p>";
        }
        // Testa bokstäver
        $svar= hamtaEnskildUppgift((int)"sju");
        if ($svar->getStatus()===400){
            $retur.= "<p class='ok'>Hämta enskild med bokstäver tal ger förväntat svar 400</p>";
        } else {
            $retur.= "<p class='error'>Hämta enskild med bokstäver('sju') tal ger {$svar->getStatus()} "."inte förväntat svar 400</p>";
        }
        // Testa giltigt tal
        $svar= hamtaEnskildUppgift(3);
        if ($svar->getStatus()===200){
            $retur.= "<p class='ok'>Hämta enskild med 3 ger förväntat svar 200</p>";
        } else {
            $retur.= "<p class='error'>Hämta enskild med 3 ger {$svar->getStatus()} "."inte förväntat svar 200</p>";
        }
    } catch (exception $ex) {
        $retur .="<p class='error'>Något gick fel, meddelandet säger:<br> {$ex->getMessage()}</p>";
    }
    return $retur;
}

/**
 * Test för funktionen spara uppgift
 * @return string html-sträng med alla resultat för testerna
 */
function test_SparaUppgift(): string {
    $retur = "<h2>test_SparaUppgift</h2>";
    $retur .= "<p class='ok' >Borde jag gå in på git?</p>";
    return $retur;
     echo  "bara om man gör det rätt";
}

/**
 * Test för funktionen uppdatera befintlig uppgift
 * @return string html-sträng med alla resultat för testerna
 */
function test_UppdateraUppgifter(): string {
    $retur = "<h2>test_UppdateraUppgifter</h2>";
    $retur .= "<p class='ok'>Testar uppdatera uppgift</p>";
    return $retur;
}

/**
 * Test för funktionen radera uppgift
 * @return string html-sträng med alla resultat för testerna
 */
function test_RaderaUppgift(): string {
    $retur = "<h2>test_RaderaUppgift</h2>";
    $retur .= "<p class='ok'>Testar radera uppgift</p>";
    return $retur;
}
