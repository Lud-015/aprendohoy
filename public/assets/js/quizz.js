// This Quizz Is Powred By Walid
// Setup Varible And Const
const Question = document.getElementById("question");
const ScooreDom = document.getElementById('answer-Score')
// Transform the Class To Array For Using Later
const Choice = Array.from(document.getElementsByClassName("choice"));
Questions = preguntas.map(function(pregunta) {
    return {
        question: pregunta.texto_pregunta,
        choice1: pregunta.respuestas[0].texto_respuesta,
        choice2: pregunta.respuestas[1].texto_respuesta,
        choice3: pregunta.respuestas[2].texto_respuesta,
        choice4: pregunta.respuestas[3].texto_respuesta,
        answer: pregunta.respuesta_correcta_id
    };
});
console.log(Questions);


let CurrentQ={};
let AvaibleQ=[];
let Score = 0;
let CounterQ=0;
const MaxQ=6;
const ScoreQ=10;
let AcceptQ=true
/*
 Start Game :
        1- initalisation Score and Counter Question
        2- Affectation Object Question TO Empty Array In Order to Have A Avaible Questions
        3- Get a NextQuestion Function
*/
function StartGame()
{
    CounterQ=0;
    Score=0;
    AvaibleQ=[...Questions]
    NextQ();
}
/*
    Next Question Function:
        1- Incrematation Counter Question
        2- Search A Index For a Random Question
        3- Get a CurrentQ (affectation a index that I Looked For To Empty Object CurrentQ )
        4- Print in Dom New Question Of Object
        5- Set Variable For Specify Choice  And Print Him To Dom (It's array Ussing A ForEach())
        6- Remove A Question Using
        7- transmit To Page

*/
function NextQ()
{
    // Incrematation Counter Question
        CounterQ=CounterQ+1;
    // Using Math.floor() For getting Natural Number And Math.Random() For Getting Random Number
        var IndexQ= Math.floor(Math.random()*AvaibleQ.length);
    // Affectation IndexQ To CurrentQ
        CurrentQ=AvaibleQ[IndexQ];
    // Print Current Question In Dom
        Question.innerHTML=CurrentQ.question;
    // Set Variable For Specify Choice  And Print Him To Dom (It's array Ussing A ForEach())
        Choice.forEach(function(Elements)
    {
        // Get attribute For Specify Each "Chaque" Choice In Game.Html
            const Number = Elements.getAttribute("data-value");
        // Print To Dom With Help Number For Specify Each Choice
    // CurrentQ["Choice+Number"] Because Of In Objects Question I Have Choice1 .... So Concate Choice With Number To Get Choice1...
            Elements.innerHTML = CurrentQ["choice"+ Number]
        // Remove A CurentQ
            AvaibleQ.splice(IndexQ,0)
        // Accapting Quetions Is True
            AcceptQ = true ;
            const Question = document.getElementById("answer-question");
            Question.innerHTML = CounterQ;
    })
}
/* Whats Happens In The Click
    1-Using ForEach To Get Each Choice
    2- Using Event Click
    3- Make Some Condition To Check Answers
    4- Get Data Of Users
    5- Add Class To ChoiceUser
    6- Manupilate Class To Css
    7- Call Function SetTimeOut Make a Delay And After Call NextQ();
        7-1 Addtion And subtraction Score In each Condition(CheckChoice==CurrentQ.answer)
*/
    //Using ForEach To Get Each Choice
     Choice.forEach(function(choice)
     {
         choice.addEventListener("click",function(ele)
         {

            // Save Data Of Users
                const ChoiceUsers = ele.target
                const CheckChoice = ChoiceUsers.getAttribute("data-value");
            // Check Answer
                if (CheckChoice==CurrentQ.answer)
                    {
                     // Add Class For Using In Css
                            ChoiceUsers.classList.add("Corr");
                     // Delay To Delete A Creat Class  After Call NextQ()
                            setTimeout(function()
                            {
                                ChoiceUsers.classList.remove("Corr");
                                NextQ();
                            },1000)
                            // If Always True For Addition Score
                                if (true)
                                {
                                    Score+=ScoreQ
                                    ScooreDom.innerHTML=Score;
                                }
                    }
                            else
                                {
                                // Add Class For Using In Css
                                        ChoiceUsers.classList.add("InCorr");
                                // Delay To Delete A Creat Class After Call NextQ()
                                        setTimeout(function()
                                        {
                                            ChoiceUsers.classList.remove("InCorr");
                                            NextQ();

                                        },1000)
                                        // If Always True For Subtration Score
                                            if (true)
                                            {
                                                Score-=ScoreQ
                                                ScooreDom.innerHTML=Score;
                                            }
                                }
         })

     })
StartGame();
