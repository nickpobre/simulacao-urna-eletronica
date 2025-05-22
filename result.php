<?php
require_once 'db.php';

$stmt = $pdo->query("SELECT candidato, COUNT(*) as total FROM votos WHERE tipo = 'nominal' GROUP BY candidato ORDER BY total DESC");
$nominais = $stmt->fetchAll(PDO::FETCH_ASSOC);

$blank = $pdo->query("SELECT COUNT(*) FROM votos WHERE tipo = 'blank'")->fetchColumn();

$null = $pdo->query("SELECT COUNT(*) FROM votos WHERE tipo = 'null'")->fetchColumn();

// Calcular o total de votos para percentuais
$totalVotos = 0;
foreach ($nominais as $voto) {
    $totalVotos += $voto['total'];
}
$totalVotos += $blank + $null;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Votação</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-5xl">
        <header class="mb-8 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Resultado da Votação</h1>
            <div class="h-1 w-24 bg-blue-500 mx-auto rounded-full"></div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Card para votos nominais -->
            <div class="md:col-span-2 bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white">Votos Nominais</h2>
                </div>
                <div class="p-6">
                    <?php if (count($nominais) > 0): ?>
                        <div class="space-y-4">
                            <?php foreach ($nominais as $index => $linha): 
                                $percentual = $totalVotos > 0 ? round(($linha['total'] / $totalVotos) * 100, 1) : 0;
                                // Cores alternadas para as barras
                                $barColor = $index % 2 == 0 ? 'bg-blue-500' : 'bg-green-500';
                            ?>
                                <div class="mb-4">
                                    <div class="flex justify-between mb-1">
                                        <span class="font-medium text-gray-700">Candidato <?php echo htmlspecialchars($linha['candidato']); ?></span>
                                        <span class="text-gray-600"><?php echo $linha['total']; ?> votos (<?php echo $percentual; ?>%)</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="<?php echo $barColor; ?> h-2.5 rounded-full" style="width: <?php echo $percentual; ?>%"></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500 italic">Nenhum voto nominal registrado.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Card para outros tipos de votos -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gray-700 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white">Outros Votos</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-6">
                        <?php 
                            $percentualBranco = $totalVotos > 0 ? round(($blank / $totalVotos) * 100, 1) : 0;
                            $percentualNulo = $totalVotos > 0 ? round(($null / $totalVotos) * 100, 1) : 0;
                        ?>
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="font-medium text-gray-700">Votos em branco</span>
                                <span class="text-gray-600"><?php echo $blank; ?> (<?php echo $percentualBranco; ?>%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-gray-400 h-2.5 rounded-full" style="width: <?php echo $percentualBranco; ?>%"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="font-medium text-gray-700">Votos nulos</span>
                                <span class="text-gray-600"><?php echo $null; ?> (<?php echo $percentualNulo; ?>%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-red-400 h-2.5 rounded-full" style="width: <?php echo $percentualNulo; ?>%"></div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <div class="flex justify-between font-medium">
                                <span class="text-gray-800">Total de votos:</span>
                                <span class="text-gray-800"><?php echo $totalVotos; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-center mt-8">
            <a href="index.php" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Voltar
            </a>
        </div>
    </div>
</body>
</html>