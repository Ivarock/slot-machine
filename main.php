<?php

$coins = (int)readline("Enter the amount of coins: ");
while ($coins <= 0 || $coins != is_integer($coins)) {
    $coins = (int)readline("Invalid input. Enter the amount of coins: ");
}

$bet = (int)readline("Enter your bet per turn: ");
while ($bet <= 0 || $bet > $coins || $bet != is_integer($bet)) {
    $bet = (int)readline("Invalid input. Enter your bet per turn: ");
}

while (true) {
    echo "- Your balance: $coins ";
    echo "- Cost of bet: $bet ";
    echo "- Press 'enter' to spin ";
    echo "- 1. Add coins ";
    echo "- 2. Change bet ";
    echo "- 3. Cash out ";
    $choice = readline("- Your choice: ");

    switch ($choice) {
        case 1:
            $addCoins = (int)readline("Enter the amount of coins: ");
            if ($addCoins <= 0 || $addCoins != is_integer($coins)) {
                echo "Invalid input\n";
            } else {
                $coins += $addCoins;
            }
            break;
        case 2:
            $newBet = (int)readline("Enter your bet per turn: ");
            if ($newBet <= 0 || $newBet != is_integer($newBet)) {
                echo "Invalid input\n";
            } elseif ($newBet > $coins) {
                echo "You don't have enough coins\n";
            } else {
                $bet = $newBet;
            }
            break;
        case 3:
            echo "Cashing out $coins coins. Thank you for playing\n";
            exit;
        case '':
            if ($bet > $coins) {
                echo "You don't have enough coins\n";
                break;
            }
            if ($coins <= 0) {
                echo "You are out of coins, please deposit coins to play\n";
                break;
            }

            $coins -= $bet;
            $rows = 3;
            $columns = 3;
            $board = [];
            $elements =
                [
                    ["symbol" => '♦', "value" => 1],
                    ["symbol" => '♦', "value" => 1],
                    ["symbol" => '♥', "value" => 2],
                    ["symbol" => '♪', "value" => 3],
                    ["symbol" => '£', "value" => 5],
                    ["symbol" => '$', "value" => 10]
                ];
            $winningLines =
                [
                    [[0, 0], [0, 1], [0, 2]],
                    [[1, 0], [1, 1], [1, 2]],
                    [[2, 0], [2, 1], [2, 2]],
                    [[0, 0], [1, 1], [2, 2]],
                    [[2, 0], [1, 1], [0, 2]],
                ];
            for ($row = 0; $row < $rows; $row++) {
                for ($column = 0; $column < $columns; $column++) {
                    $board[$row][$column] = $elements[array_rand($elements)]['symbol'];
                }
            }
            foreach ($board as $row) {
                foreach ($row as $element) {
                    echo $element;
                }
                echo PHP_EOL;
            }
            foreach ($winningLines as $line) {
                $symbols = [];
                foreach ($line as $coordinates) {
                    $symbols[] = $board[$coordinates[0]][$coordinates[1]];
                }
                if (count(array_unique($symbols)) === 1) {
                    $winningSymbol = $symbols[0];
                    $winAmount = $bet * $elements[array_search($winningSymbol, array_column($elements, 'symbol'))]['value'];
                    echo "You won $winAmount\n";
                    $coins += $winAmount;
                }
            }
    }
}

