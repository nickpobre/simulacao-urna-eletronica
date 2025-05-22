<!DOCTYPE html>
<html>

<head>
    <title>Urna Eletrônica</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
    <section class="w-full h-screen flex flex-col items-center justify-center bg-[#C8C1AF]">
        <a href="result.php" class="ml-auto mr-auto text-blue-500 font-bold pt-2">Ver Resultados</a>
        <form id="votoForm" action="vote.php" method="POST"
            class="w-full h-screen flex flex-col md:flex-row items-center justify-center">
            <div class="w-full md:w-1/2 border p-2 md:p-6 relative bg-white">
                <h1 class="absolute top-2 text-gray-400">SEU VOTO PARA</h1>
                <h1 class="font-bold mt-4 text-center">PRESIDENTE</h1>

                <input type="hidden" name="candidate" id="hiddenCandidate">
                <input type="hidden" name="type" id="hiddenType">

                <div class="flex w-full gap-1 mt-10">
                    <label for="number">Número:</label>
                    <input type="text" class="border w-9 text-center" id="candidate">
                    <input type="text" class="border w-9 text-center" id="candidate2">
                    <input type="text" class="border w-9 text-center">
                    <input type="text" class="border w-9 text-center">
                </div>
                <div class="flex w-full gap-1 flex-col mt-10">
                    <div class="flex gap-1">
                        <label for="partido">Partido:</label>
                        <p id="partido"></p>
                    </div>
                    <div class="flex gap-1">
                        <label for="nome">Candidato:</label>
                        <p id="nome"></p>
                    </div>
                </div>
                <div class="border-t mt-10">
                    <p>Aperte a tecla:</p>
                    <p>CONFIRMA para PROSSEGUIR</p>
                    <p>CORRIGE para REINICIAR este voto</p>
                </div>

            </div>
            <div class="w-full md:w-fit h-auto p-2 md:p-6">
                <div class="w-full flex items-center border bg-white px-2">
                    <img src="https://www.fatecsenaimt.ind.br/img/fatec-senai-mt.png" alt="" class="h-5">
                    <div class="ml-auto">
                        <p class="font-bold text-2xl text-center">JUSTIÇA <br>DA FATEC</p>
                        <small class="text-xs text-gray-200">Estamos de olho no seu voto anônimo</small>
                    </div>
                </div>
                <div class="w-full flex flex-col items-center justify-center bg-black/90">
                    <div class="grid grid-cols-3 gap-2 w-40 mt-10">
                        <button type="button" class="p-2 bg-black text-white shadow-sm"
                            onclick="inserirNumero('1')">1</button>
                        <button type="button" class="p-2 bg-black text-white shadow-sm"
                            onclick="inserirNumero('2')">2</button>
                        <button type="button" class="p-2 bg-black text-white shadow-sm"
                            onclick="inserirNumero('3')">3</button>
                        <button type="button" class="p-2 bg-black text-white shadow-sm"
                            onclick="inserirNumero('4')">4</button>
                        <button type="button" class="p-2 bg-black text-white shadow-sm"
                            onclick="inserirNumero('5')">5</button>
                        <button type="button" class="p-2 bg-black text-white shadow-sm"
                            onclick="inserirNumero('6')">6</button>
                        <button type="button" class="p-2 bg-black text-white shadow-sm"
                            onclick="inserirNumero('7')">7</button>
                        <button type="button" class="p-2 bg-black text-white shadow-sm"
                            onclick="inserirNumero('8')">8</button>
                        <button type="button" class="p-2 bg-black text-white shadow-sm"
                            onclick="inserirNumero('9')">9</button>
                        <div></div>
                        <button type="button" class="p-2 bg-black text-white shadow-sm"
                            onclick="inserirNumero('0')">0</button>
                        <div></div>
                    </div>
                    <div class="flex gap-2 mt-10 mb-10">
                        <button type="button" class="bg-white border px-4 py-2" onclick="votoBranco()">Branco</button>
                        <button type="button" class="bg-orange-400 px-4 py-2 text-white"
                            onclick="corrigir()">Corrige</button>
                        <button type="button" class="bg-green-600 px-4 py-2 text-white"
                            onclick="confirmar()">Confirma</button>
                    </div>
                </div>
            </div>
        </form>
    </section>
    


    <script>
        const input1 = document.getElementById('candidate');
        const input2 = document.getElementById('candidate2');
        const partido = document.getElementById('partido');
        const nome = document.getElementById('nome');
        const hiddenInput = document.getElementById('hiddenCandidate');

        function buscarCandidato() {
            const numero = input1.value + input2.value;
            hiddenInput.value = numero;

            if (numero.length === 2) {
                fetch(`get_candidato.php?numero=${numero}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.error) {
                            partido.innerHTML = '';
                            nome.innerHTML = '';
                        } else {
                            partido.innerHTML = data.partido;
                            nome.innerHTML = data.nome;
                        }
                    })
                    .catch(() => {
                        partido.innerHTML = '';
                        nome.innerHTML = '';
                    });
            } else {
                partido.innerHTML = '';
                nome.innerHTML = '';
            }
        }

        function inserirNumero(num) {
            if (input1.value === '') {
                input1.value = num;
            } else if (input2.value === '') {
                input2.value = num;
            }

            const numero = input1.value + input2.value;
            hiddenInput.value = numero;

            if (numero.length === 2) {
                buscarCandidato();
            }
        }

        function corrigir() {
            input1.value = '';
            input2.value = '';
            partido.innerHTML = '';
            nome.innerHTML = '';
            hiddenInput.value = '';
        }

        function votoBranco() {
            corrigir();
            nome.innerHTML = 'VOTO EM BRANCO';
            hiddenInput.value = 'branco';
            document.getElementById('hiddenType').value = 'blank';
            document.getElementById('votoForm').submit();
        }
        function confirmar() {
            document.getElementById('hiddenType').value = 'nominal';
            document.getElementById('votoForm').submit();
        }
        input1.addEventListener('input', buscarCandidato);
        input2.addEventListener('input', buscarCandidato);
    </script>
</body>

</html>