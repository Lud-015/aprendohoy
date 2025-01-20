<link rel="stylesheet" href="{{ asset('assets/css/quizz.css') }}">


@section('content')
<div class="quiz-container">
    <div class="quiz-header">
        <h1>Cuestionario</h1>
        <div class="progress-bar"></div>
    </div>
    <div class="quiz-question">
        <p id="question-text"></p>
    </div>
    <div class="answer-choices">
        <form id="answer-form">
            <ul id="answer-list"></ul>
        </form>
    </div>
    <div class="feedback">
        <p id="feedback-message"></p>
    </div>
    <div class="countdown">
        <p>Time Left: <span id="countdown">20</span> seconds</p>
    </div>
    <div class="navigation">
        <button id="start-btn">Start Quiz</button>
        <button id="prev-btn" style="display: none;">Previous</button>
        <button id="next-btn" style="display: none;">Next</button>
    </div>
    <div id="quiz-summary" style="display: none;">
        <h2>Quiz Summary</h2>
        <ul id="quiz-results"></ul>
        <button id="restart-btn">Restart</button>
    </div>
</div>

<div id="quiz-data" data-quiz-data='@json($quizData)'></div>
@endsection




<script>

document.addEventListener('DOMContentLoaded', function () {
    const quizDataElement = document.getElementById('quiz-data');
    const quizData = JSON.parse(quizDataElement.dataset.quizData);
    let questionIndex = 0;
    let score = 0;
    let countdown = 20;
    let countdownInterval;

    const questionText = document.getElementById('question-text');
    const answerList = document.getElementById('answer-list');
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

    // Función para mostrar la pregunta actual
    function displayQuestion() {
        clearInterval(countdownInterval); // Limpiar intervalo actual antes de iniciar uno nuevo

        const currentQuestion = quizData[questionIndex];
        questionText.textContent = currentQuestion.texto_pregunta;

        // Ordenar aleatoriamente las opciones de respuesta
        const shuffledChoices = shuffleArray(currentQuestion.choices);

        // Limpiar y poblar las opciones de respuesta
        answerList.innerHTML = '';
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

        // Actualizar la barra de progreso
        progressBar.style.width = `${(questionIndex + 1) / quizData.length * 100}%`;

        // Mostrar/ocultar botones de navegación
        prevBtn.style.display = questionIndex === 0 ? 'none' : 'block';
        nextBtn.textContent = questionIndex === quizData.length - 1 ? 'Finish' : 'Next';

        // Iniciar el contador regresivo
        startCountdown();
    }

    // Función para iniciar el contador regresivo
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

    // Función para deshabilitar respuestas
    function disableAnswers() {
        const answerInputs = document.querySelectorAll('input[name="answer"]');
        answerInputs.forEach(input => {
            input.disabled = true;
        });
    }

    // Función para omitir pregunta cuando se acabe el tiempo
    function skipQuestion() {
        questionIndex++;
        if (questionIndex < quizData.length) {
            displayQuestion();
        } else {
            finishQuiz();
        }
    }

    // Función para verificar la respuesta del usuario
    function checkAnswer() {
        const selectedAnswer = document.querySelector('input[name="answer"]:checked');

        // Validar si se seleccionó una respuesta
        if (!selectedAnswer) {
            feedbackMessage.textContent = 'Please select an answer.';
            return;
        }

        const selectedAnswerIndex = parseInt(selectedAnswer.value);
        const currentQuestion = quizData[questionIndex];
        const correctAnswerIndex = currentQuestion.choices.findIndex(choice => choice.es_correcta);

        // Verificar si la respuesta seleccionada es correcta
        const isCorrect = selectedAnswerIndex === correctAnswerIndex;

        // Actualizar la puntuación
        if (isCorrect) {
            score++;
        }

        // Mostrar retroalimentación
        feedbackMessage.textContent = isCorrect ? 'Correct!' : 'Incorrect.';

        // Deshabilitar respuestas y avanzar a la siguiente pregunta
        disableAnswers();
        if (questionIndex < quizData.length - 1) {
            questionIndex++;
            displayQuestion();
        } else {
            finishQuiz();
        }
    }

    // Función para finalizar el quiz
    function finishQuiz() {
        clearInterval(countdownInterval); // Limpiar cualquier intervalo activo

        // Ocultar elementos del cuestionario
        questionText.style.display = 'none';
        answerList.style.display = 'none';
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
            const userAnswerIndex = parseInt(document.querySelector(`input[name="answer"]:checked`).value);
            const isCorrect = question.choices[userAnswerIndex].es_correcta;
            resultItem.textContent = `Question ${index + 1}: ${isCorrect ? 'Correct' : 'Incorrect'}`;
            quizResults.appendChild(resultItem);
        });

        // Mostrar puntuación final
        const scoreItem = document.createElement('li');
        scoreItem.textContent = `Final Score: ${score} / ${quizData.length}`;
        quizResults.appendChild(scoreItem);

        // Mostrar botón de reinicio
        restartBtn.style.display = 'block';
    }

    // Función para reiniciar el quiz
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
        feedbackMessage.style.display = 'none';
        progressBar.style.display = 'none';
        countdownDisplay.style.display = 'none';
    }

    // Función para ordenar aleatoriamente un array (Fisher-Yates shuffle algorithm)
    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }

    // Event listeners para botones y eventos
    startBtn.addEventListener('click', () => {
        // Ordenar aleatoriamente las preguntas al iniciar el quiz
        shuffleArray(quizData);
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
            questionIndex--;
            displayQuestion();
        }
    });

    nextBtn.addEventListener('click', checkAnswer);

    restartBtn.addEventListener('click', restartQuiz);
});




</script>

@include('FundacionPlantillaUsu.index')
