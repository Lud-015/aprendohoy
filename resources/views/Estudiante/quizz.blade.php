<link rel="stylesheet" href="{{ asset('assets/css/quizz.css') }}">


@section('content')
    <div class="quiz-container">
        <div class="quiz-header">
            <h1>Cuestionario {{ $tarea->titulo_tarea }}</h1>
            <div class="progress-bar"></div>
        </div>
        <div class="quiz-question">
            <p id="question-text"></p>
        </div>
        <div class="answer-choices">
            <ul id="answer-list"></ul>
            <input type="text" id="short-answer" style="display: none;" placeholder="Type your answer here">
        </div>
        <div class="feedback">
            <p id="feedback-message"></p>
        </div>
        <div class="countdown">
            <p>Tiempo Restante: <span id="countdown">20</span> Segundos</p>
        </div>
        <div class="navigation">
            <button id="start-btn">Empezar Cuestionario</button>
            <button id="prev-btn" style="display: none;">Atrás</button>
            <button id="next-btn" style="display: none;">Siguiente</button>
        </div>
        <div id="quiz-summary" style="display: none;">
            <h2>Sumario</h2>
            <ul id="quiz-results"></ul>
            <button id="restart-btn">Reiniciar</button>
            <!-- En la vista de Laravel -->
            <button id="save-results-btn">Guardar Resultados</button>
        </div>
    </div>

    <div id="quiz-data" data-quiz-data='@json($quizData)'></div>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quizDataElement = document.getElementById('quiz-data');
        const quizData = JSON.parse(quizDataElement.dataset.quizData);
        let questionIndex = 0;
        let score = 0;
        let countdown = 20;
        let countdownInterval;

        const questionText = document.getElementById('question-text');
        const answerList = document.getElementById('answer-list');
        const shortAnswerInput = document.getElementById('short-answer');
        const feedbackMessage = document.getElementById('feedback-message');
        const progressBar = document.querySelector('.progress-bar');
        const startBtn = document.getElementById('start-btn');
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        const restartBtn = document.getElementById('restart-btn');
        const quizSummary = document.getElementById('quiz-summary');
        const quizResults = document.getElementById('quiz-results');
        const countdownDisplay = document.getElementById('countdown');
        const countdownContainer = document.querySelector('.countdown');

        function displayQuestion() {
            clearInterval(countdownInterval); // Limpiar intervalo actual antes de iniciar uno nuevo

            const currentQuestion = quizData[questionIndex];
            questionText.textContent = currentQuestion.texto_pregunta;

            // Limpiar y poblar las opciones de respuesta
            answerList.innerHTML = '';
            shortAnswerInput.style.display = 'none'; // Ocultar input de respuesta corta por defecto

            if (currentQuestion.tipo_preg === 'multiple') {
                // Ordenar aleatoriamente las opciones de respuesta
                const shuffledChoices = shuffleArray(currentQuestion.choices);
                shuffledChoices.forEach((choice, index) => {
                    const answerElement = document.createElement('li');
                    answerElement.innerHTML = `
                    <label>
                        <input type="radio" name="answer" value="${index}">
                        ${choice.texto_respuesta}
                    </label>
                `;
                    answerList.appendChild(answerElement);
                });
            } else if (currentQuestion.tipo_preg === 'short') {
                shortAnswerInput.style.display = 'block'; // Mostrar input de respuesta corta
            } else if (currentQuestion.tipo_preg === 'vf') {
                // Preguntas de verdadero/falso
                const vfChoices = [{
                        texto_respuesta: 'Verdadero',
                        es_correcta: currentQuestion.correcta === 'verdadero'
                    },
                    {
                        texto_respuesta: 'Falso',
                        es_correcta: currentQuestion.correcta === 'falso'
                    }
                ];
                vfChoices.forEach((choice, index) => {
                    const answerElement = document.createElement('li');
                    answerElement.innerHTML = `
                    <label>
                        <input type="radio" name="answer" value="${index}">
                        ${choice.texto_respuesta}
                    </label>
                `;
                    answerList.appendChild(answerElement);
                });
            }

            // Actualizar la barra de progreso
            progressBar.style.width = `${(questionIndex + 1) / quizData.length * 100}%`;

            // Mostrar/ocultar botones de navegación
            prevBtn.style.display = questionIndex === 0 ? 'none' : 'block';
            nextBtn.textContent = questionIndex === quizData.length - 1 ? 'Finish' : 'Siguiente';

            // Iniciar el contador regresivo
            startCountdown();
        }

        function startCountdown() {
            countdown = 20; // Reiniciar el contador a 20 segundos
            countdownDisplay.textContent = countdown;

            // Habilitar las respuestas y comenzar el contador
            const answerInputs = document.querySelectorAll('input[name="answer"]');
            answerInputs.forEach(input => {
                input.disabled = false;
            });

            countdownContainer.style.display = 'block'; // Mostrar el contador regresivo

            countdownInterval = setInterval(() => {
                countdown--;
                countdownDisplay.textContent = countdown;

                if (countdown <= 0) {
                    clearInterval(countdownInterval);
                    disableAnswers(); // Bloquear respuestas cuando se acabe el tiempo
                    skipQuestion(); // Omitir pregunta cuando se acabe el tiempo
                }
            }, 1000);
        }

        function disableAnswers() {
            const answerInputs = document.querySelectorAll('input[name="answer"]');
            answerInputs.forEach(input => {
                input.disabled = true;
            });
            if (shortAnswerInput.style.display === 'block') {
                shortAnswerInput.disabled = true;
            }
        }

        function skipQuestion() {
            questionIndex++;
            if (questionIndex < quizData.length) {
                displayQuestion();
            } else {
                finishQuiz();
            }
        }

        function checkAnswer() {
            const currentQuestion = quizData[questionIndex];
            let isCorrect = false;

            if (currentQuestion.tipo_preg === 'multiple' || currentQuestion.tipo_preg === 'vf') {
                const selectedAnswer = document.querySelector('input[name="answer"]:checked');

                // Validar si se seleccionó una respuesta
                if (!selectedAnswer) {
                    feedbackMessage.textContent = 'Selecciona una respuesta.';
                    return;
                }

                const selectedAnswerIndex = parseInt(selectedAnswer.value);
                const correctAnswerIndex = currentQuestion.choices.findIndex(choice => choice.es_correcta);

                // Verificar si la respuesta seleccionada es correcta
                isCorrect = selectedAnswerIndex === correctAnswerIndex;
            } else if (currentQuestion.tipo_preg === 'short') {
                const userAnswer = shortAnswerInput.value.trim().toLowerCase();
                const correctAnswer = currentQuestion.choices.find(choice => choice.es_correcta).texto_respuesta
                    .toLowerCase();

                // Verificar si la respuesta ingresada es correcta
                isCorrect = userAnswer === correctAnswer;
            }

            // Actualizar la puntuación si es correcta
            if (isCorrect) {
                score++;
            }

            // Mostrar retroalimentación
            // feedbackMessage.textContent = isCorrect ? 'Correct!' : 'Incorrect.';

            // Deshabilitar respuestas y avanzar a la siguiente pregunta
            disableAnswers();
            if (questionIndex < quizData.length - 1) {
                questionIndex++;
                displayQuestion();
            } else {
                finishQuiz();
            }
        }








        function finishQuiz() {
            clearInterval(countdownInterval); // Limpiar cualquier intervalo activo

            // Calcular el porcentaje de respuestas correctas
            const percentageScore = (score / quizData.length) * 100;

            // Ocultar elementos del cuestionario
            questionText.style.display = 'none';
            answerList.style.display = 'none';
            shortAnswerInput.style.display = 'none';
            feedbackMessage.style.display = 'none';
            progressBar.style.display = 'none';
            prevBtn.style.display = 'none';
            nextBtn.style.display = 'none';
            countdownContainer.style.display = 'none';

            // Mostrar el resumen del quiz
            quizSummary.style.display = 'block';

            // Mostrar resultados del quiz
            quizResults.innerHTML = '';
            quizData.forEach((question, index) => {
                const resultItem = document.createElement('li');
                let isCorrect = false;

                if (question.tipo_preg === 'multiple' || question.tipo_preg === 'vf') {
                    const selectedAnswer = document.querySelector(`input[name="answer"]:checked`);
                    const selectedAnswerIndex = selectedAnswer ? parseInt(selectedAnswer.value) : -1;
                    isCorrect = question.choices[selectedAnswerIndex]?.es_correcta || false;
                } else if (question.tipo_preg === 'short') {
                    const userAnswer = shortAnswerInput.value.trim().toLowerCase();
                    const correctAnswer = question.choices.find(choice => choice.es_correcta)
                        .texto_respuesta.toLowerCase();
                    isCorrect = userAnswer === correctAnswer;
                }

                resultItem.textContent =
                    `Pregunta ${index + 1}: ${isCorrect ? 'Correcta' : 'Incorrecta'}`;
                quizResults.appendChild(resultItem);
            });

            // Mostrar puntuación final en porcentaje
            const scoreItem = document.createElement('li');
            scoreItem.textContent =
                `Puntuación: ${score} / ${quizData.length} (${percentageScore.toFixed(2)}%)`;
            quizResults.appendChild(scoreItem);

            // Mostrar el botón de guardar resultados
            const saveResultsBtn = document.createElement('button');
            saveResultsBtn.textContent = 'Guardar Resultados';
            saveResultsBtn.addEventListener('click', (event) => {
                event
                    .preventDefault(); // Prevenir el envío inmediato del formulario para poder actualizar el campo
                captureAndSendResults(percentageScore);
            });
            quizResults.appendChild(saveResultsBtn);

            // Mostrar el botón de reinicio
            restartBtn.style.display = 'block';

            
        }









        function restartQuiz() {
            clearInterval(countdownInterval); // Limpiar cualquier intervalo activo
            questionIndex = 0;
            score = 0;

            // Restablecer botones y elementos de navegación
            startBtn.style.display = 'block';
            prevBtn.style.display = 'none';
            nextBtn.style.display = 'none';
            restartBtn.style.display = 'none';
            countdownContainer.style.display = 'none';

            // Ocultar elementos del resumen del quiz
            quizSummary.style.display = 'none';
            quizResults.innerHTML = '';

            // Ocultar los elementos iniciales del cuestionario
            questionText.style.display = 'none';
            answerList.style.display = 'none';
            shortAnswerInput.style.display = 'none';
            feedbackMessage.style.display = 'none';
            progressBar.style.display = 'none';
            countdownDisplay.style.display = 'none';
        }

        function shuffleArray(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        }

        startBtn.addEventListener('click', () => {
            shuffleArray(quizData); // Ordenar aleatoriamente las preguntas al iniciar el quiz
            startBtn.style.display = 'none'; // Ocultar el botón de inicio
            questionText.style.display = 'block';
            answerList.style.display = 'block';
            feedbackMessage.style.display = 'block';
            progressBar.style.display = 'block';
            countdownDisplay.style.display = 'block';
            prevBtn.style.display = 'block'; // Mostrar el botón anterior
            nextBtn.style.display = 'block'; // Mostrar el botón siguiente
            countdownContainer.style.display = 'block'; // Mostrar el contador regresivo
            displayQuestion(); // Mostrar la primera pregunta
        });

        prevBtn.addEventListener('click', () => {
            if (questionIndex > 0) {
                questionIndex--; // Decrementar el índice para retroceder a la pregunta anterior
                displayQuestion(); // Mostrar la pregunta actualizada
            }
        });

        nextBtn.addEventListener('click', checkAnswer);

        restartBtn.addEventListener('click', restartQuiz);





    });
</script>

@include('FundacionPlantillaUsu.index')
