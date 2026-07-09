<!-- ============================================ -->
<!-- PRACTICE QUESTIONS PAGE -->
<!-- ============================================ -->
<section class="about-section inner-padding">
    <div class="container">
        
        <!-- ===== HEADER ===== -->
        <div class="section-title text-center">
            <span class="sub-title">Practice / अभ्यास</span>
            <h2 class="char-animation"><?= $syllabus->class_name ?? 'Nursery' ?> <span><?= $syllabus->subject_name ?? 'Hindi' ?></span> Learning & Practice</h2>
        </div>
        
        <!-- ============================================ -->
        <!-- QUESTIONS -->
        <!-- ============================================ -->
        <?php if(!empty($questions)): ?>
        <form id="practiceForm" method="POST">
            <input type="hidden" name="syllabus_id" value="<?= $syllabus->id ?? '' ?>">
            
            <?php foreach($questions as $index => $q): ?>
            <div class="question-item" data-question="<?= $index + 1 ?>" data-id="<?= $q->id ?>" style="display: <?= $index == 0 ? 'block' : 'none' ?>;">
                
                <div class="question-wrapper">
                    
                    <!-- ===== LEFT: QUESTION & OPTIONS ===== -->
                    <div class="question-left">
                        <h2 class="question-title">
                            <?= $index + 1 ?>. <?= htmlspecialchars($q->question_text) ?>
                        </h2>
                          <?php if(!empty($q->question_image)){ ?>
                        <a class="cursor">
                    <img src="<?= base_url('assets/questions/' . $q->question_image) ?>" style="max-width: 200px;margin-bottom: 50px;" alt="" class="img-responsive "></a>
                          <?php }  ?>
                        <div class="options-row">
                            <!-- Option A -->
                            <div class="option-box" onclick="selectOption(this, '<?= $q->id ?>', 'A', '<?= $q->correct_answer ?>', <?= $index + 1 ?>)">
                                <div class="option-inner" id="option_a_<?= $q->id ?>">
                                    <?php if($q->option_a_type == 'image' && !empty($q->option_a_image)): ?>
                                        <img src="<?= base_url('assets/questions/' . $q->option_a_image) ?>">
                                    <?php else: ?>
                                        <span><?= htmlspecialchars($q->option_a_text ?? 'Option A') ?></span>
                                    <?php endif; ?>
                                    <input type="radio" class="d-none" name="answers[<?= $q->id ?>]" value="A">
                                </div>
                                <p class="option-label">Group-A</p>
                            </div>
                            
                            <!-- Option B -->
                            <div class="option-box" onclick="selectOption(this, '<?= $q->id ?>', 'B', '<?= $q->correct_answer ?>', <?= $index + 1 ?>)">
                                <div class="option-inner" id="option_b_<?= $q->id ?>">
                                    <?php if($q->option_b_type == 'image' && !empty($q->option_b_image)): ?>
                                        <img src="<?= base_url('assets/questions/' . $q->option_b_image) ?>">
                                    <?php else: ?>
                                        <span><?= htmlspecialchars($q->option_b_text ?? 'Option B') ?></span>
                                    <?php endif; ?>
                                    <input type="radio" class="d-none" name="answers[<?= $q->id ?>]" value="B">
                                </div>
                                <p class="option-label">Group-B</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- ===== RIGHT: ANSWER STATUS ===== -->
                    <div class="answer-right">
                        <h3 class="answer-title">Your Answer</h3>
                        
                        <div id="answerStatus_<?= $q->id ?>" class="answer-status">
                            <p class="not-answered">Not answered yet</p>
                        </div>
                        
                        <!-- ===== NAVIGATION ===== -->
                        <div class="nav-section">
                            <?php if($index < count($questions) - 1): ?>
                            <button type="button" class="next-btn" id="nextBtn_<?= $index + 1 ?>" 
                                    data-current="<?= $index + 1 ?>" 
                                    onclick="nextQuestion(<?= $index + 1 ?>)" disabled>
                                Next ➜
                            </button>
                            <?php else: ?>
                            <button type="button" class="next-btn" id="showResultBtn" 
                                    onclick="showFinalResult()" disabled>
                                Show Result
                            </button>
                            <?php endif; ?>
                        </div>
                        
                        <!-- ===== PROGRESS ===== -->
                        <div class="progress-section">
                            <span><span id="answeredCount">0</span>/<?= count($questions ?? []) ?> Answered</span>
                            <div class="progress-bar-line">
                                <div class="progress-fill" id="progressBar" style="width: 0%;"></div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <?php endforeach; ?>
        </form>
        
        <!-- ===== FINAL RESULT ===== -->
        <div id="finalResult" style="display: none; margin-top: 40px;">
            <div class="result-card" id="resultCard">
                <!-- Result will be shown here -->
            </div>
        </div>
        
        <?php else: ?>
        <div class="text-center py-5">
            <h3>No Questions Available</h3>
            <a href="<?= base_url('practice') ?>" class="theme-btn">Back to Practice</a>
        </div>
        <?php endif; ?>
        
    </div>
</section>

<!-- ============================================ -->
<!-- STYLES -->
<!-- ============================================ -->
<style>
/* ===== GLOBAL ===== */
.inner-padding {
    padding: 60px 0;
}
.section-title .sub-title {
    display: inline-block;
    background: #4e73df;
    color: #fff;
    padding: 5px 20px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 10px;
}
.section-title h2 {
    font-size: 32px;
    font-weight: 700;
    color: #2d3748;
}
.section-title h2 span {
    color: #4e73df;
}

/* ===== QUESTION WRAPPER ===== */
.question-wrapper {
    display: flex;
    gap: 40px;
    padding: 30px 0;
    border-bottom: 2px solid #f0f0f0;
    margin-top: 20px;
}

/* ===== LEFT SIDE ===== */
.question-left {
    flex: 2;
}
.question-title {
    font-size: 22px;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 25px;
}
.options-row {
    display: flex;
    gap: 30px;
}
.option-box {
    flex: 1;
    cursor: pointer;
    transition: all 0.3s ease;
}
.option-box:hover {
    transform: translateY(-5px);
}
.option-inner {
    border: 3px solid #ddd;
    border-radius: 12px;
    padding: 30px 20px;
    text-align: center;
    min-height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    background: #fafafa;
    transition: all 0.3s ease;
}
.option-inner img {
    max-width: 80%;
    max-height: 100px;
    object-fit: contain;
}
.option-inner span {
    font-size: 22px;
    font-weight: 600;
    color: #333;
}
.option-label {
    font-weight: 600;
    font-size: 15px;
    color: #666;
    margin-top: 10px;
    text-align: center;
}

/* ===== SELECTED STATES ===== */
.option-box.selected-correct .option-inner {
    border-color: #28a745 !important;
    background: #d4edda !important;
    transform: scale(1.02);
}
.option-box.selected-correct .option-inner span {
    color: #155724 !important;
}

.option-box.selected-wrong .option-inner {
    border-color: #dc3545 !important;
    background: #f8d7da !important;
    transform: scale(1.02);
}
.option-box.selected-wrong .option-inner span {
    color: #721c24 !important;
}

.option-box.show-correct .option-inner {
    border-color: #ffc107 !important;
    background: #fff3cd !important;
    transform: scale(1.02);
}
.option-box.show-correct .option-inner span {
    color: #856404 !important;
}

.option-box.disabled {
    cursor: default !important;
}
.option-box.disabled:hover {
    transform: none !important;
}

/* ===== RIGHT SIDE ===== */
.answer-right {
    flex: 1;
    padding: 20px;
    min-width: 250px;
}
.answer-title {
    font-size: 18px;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 15px;
}
.answer-status {
    min-height: 80px;
    display: flex;
    align-items: center;
}
.not-answered {
    color: #999;
    font-size: 16px;
}

/* ===== FEEDBACK ===== */
.feedback-correct {
    background: #d4edda;
    color: #155724;
    padding: 12px 18px;
    border-radius: 10px;
    border-left: 5px solid #28a745;
    width: 100%;
}
.feedback-correct .result-text {
    font-size: 18px;
    font-weight: 700;
}
.feedback-correct .result-text i {
    color: #28a745;
}
.feedback-correct .hi-text {
    font-size: 14px;
    margin-top: 3px;
}

.feedback-wrong {
    background: #f8d7da;
    color: #721c24;
    padding: 12px 18px;
    border-radius: 10px;
    border-left: 5px solid #dc3545;
    width: 100%;
}
.feedback-wrong .result-text {
    font-size: 18px;
    font-weight: 700;
}
.feedback-wrong .result-text i {
    color: #dc3545;
}
.feedback-wrong .hi-text {
    font-size: 14px;
    margin-top: 3px;
}
.feedback-wrong .correct-answer-box {
    background: #fff3cd;
    color: #856404;
    padding: 6px 12px;
    border-radius: 6px;
    margin-top: 8px;
    font-size: 14px;
    border: 1px solid #ffc107;
}
.feedback-wrong .correct-answer-box i {
    color: #28a745;
}

/* ===== NAVIGATION ===== */
.nav-section {
    margin-top: 20px;
}
.next-btn {
    background: #4e73df;
    color: #fff;
    border: none;
    padding: 10px 30px;
    border-radius: 50px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    width: 100%;
}
.next-btn:hover:not(:disabled) {
    background: #224abe;
    transform: translateY(-2px);
}
.next-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none !important;
}

/* ===== PROGRESS ===== */
.progress-section {
    margin-top: 15px;
}
.progress-section span {
    font-size: 14px;
    color: #666;
}
.progress-bar-line {
    width: 100%;
    height: 6px;
    background: #e9ecef;
    border-radius: 10px;
    margin-top: 5px;
    overflow: hidden;
}
.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #28a745, #20c997);
    border-radius: 10px;
    transition: width 0.5s ease;
}

/* ===== FINAL RESULT ===== */
.result-card {
    text-align: center;
    padding: 40px 20px;
    max-width: 600px;
    margin: 0 auto;
}
.result-card .emoji {
    font-size: 70px;
    margin-bottom: 15px;
}
.result-card .result-title {
    font-size: 32px;
    font-weight: 800;
    margin-bottom: 8px;
}
.result-card .result-subtitle {
    font-size: 18px;
    color: #666;
    margin-bottom: 20px;
}
.result-card .result-stats {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin: 25px 0;
}
.result-card .stat-item {
    text-align: center;
}
.result-card .stat-number {
    font-size: 34px;
    font-weight: 800;
}
.result-card .stat-label {
    font-size: 13px;
    color: #666;
}
.result-card .stat-item.correct .stat-number {
    color: #28a745;
}
.result-card .stat-item.wrong .stat-number {
    color: #dc3545;
}
.result-card .stat-item.total .stat-number {
    color: #4e73df;
}
.result-card .percentage-text {
    font-size: 28px;
    font-weight: 800;
    margin: 15px 0 25px 0;
}
.result-card .result-btns {
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
}
.result-card .result-btn {
    display: inline-block;
    padding: 10px 30px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 15px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s;
}
.result-card .result-btn.retry {
    background: #28a745;
    color: #fff;
}
.result-card .result-btn.retry:hover {
    background: #1e7e34;
    transform: translateY(-3px);
}
.result-card .result-btn.home {
    background: #4e73df;
    color: #fff;
}
.result-card .result-btn.home:hover {
    background: #224abe;
    transform: translateY(-3px);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 992px) {
    .question-wrapper {
        flex-direction: column;
        gap: 20px;
        padding: 20px 0;
    }
    .answer-right {
        min-width: auto;
        padding: 15px 0;
    }
    .options-row {
        flex-direction: column;
        gap: 15px;
    }
    .option-inner {
        min-height: 100px;
        padding: 20px;
    }
    .option-inner span {
        font-size: 18px !important;
    }
    .question-title {
        font-size: 20px;
    }
}

@media (max-width: 768px) {
    .inner-padding {
        padding: 30px 0;
    }
    .section-title h2 {
        font-size: 22px;
    }
    .question-wrapper {
        padding: 15px 0;
    }
    .question-title {
        font-size: 18px;
    }
    .option-inner {
        min-height: 80px;
        padding: 15px;
    }
    .option-inner span {
        font-size: 16px !important;
    }
    .option-inner img {
        max-width: 60% !important;
        max-height: 60px !important;
    }
    .feedback-correct .result-text,
    .feedback-wrong .result-text {
        font-size: 16px;
    }
    .result-card .emoji {
        font-size: 50px;
    }
    .result-card .result-title {
        font-size: 24px;
    }
    .result-card .stat-number {
        font-size: 26px;
    }
    .result-card .result-stats {
        gap: 15px;
    }
}
</style>

<!-- ============================================ -->
<!-- SCRIPTS -->
<!-- ============================================ -->
<script>
    // =============================================
    // VARIABLES
    // =============================================
    let currentQuestion = 1;
    const totalQuestions = <?= count($questions ?? []) ?>;
    const questionStatus = {};
    let correctCount = 0;
    let wrongCount = 0;

    // =============================================
    // SELECT OPTION
    // =============================================
    function selectOption(element, questionId, selectedValue, correctAnswer, questionNum) {
        if (questionStatus[questionId]) {
            return;
        }
        
        const questionItem = element.closest('.question-item');
        const optionA = document.getElementById('option_a_' + questionId);
        const optionB = document.getElementById('option_b_' + questionId);
        const optionABox = optionA.closest('.option-box');
        const optionBBox = optionB.closest('.option-box');
        
        questionItem.querySelectorAll('.option-box').forEach(box => {
            box.classList.remove('selected-correct', 'selected-wrong', 'show-correct');
        });
        
        const isCorrect = (selectedValue === correctAnswer);
        const statusDiv = document.getElementById('answerStatus_' + questionId);
        
        if (isCorrect) {
            correctCount++;
            element.classList.add('selected-correct');
            statusDiv.innerHTML = `
                <div class="feedback-correct">
                    <div class="result-text"><i class="fas fa-check-circle"></i> CORRECT</div>
                    <div class="hi-text">✅ सही! बहुत अच्छे!</div>
                </div>
            `;
        } else {
            wrongCount++;
            element.classList.add('selected-wrong');
            
            if (correctAnswer === 'A') {
                optionABox.classList.add('show-correct');
            } else {
                optionBBox.classList.add('show-correct');
            }
            
            const optionText = correctAnswer === 'A' ? 'A' : 'B';
            statusDiv.innerHTML = `
                <div class="feedback-wrong">
                    <div class="result-text"><i class="fas fa-times-circle"></i> WRONG</div>
                    <div class="hi-text">❌ गलत!</div>
                    <div class="correct-answer-box">
                        <i class="fas fa-check-circle"></i> Correct Answer: Option ${optionText}
                    </div>
                </div>
            `;
        }
        
      /*  questionItem.querySelectorAll('.option-box').forEach(box => {
            box.classList.add('disabled');
        });*/
        
        questionStatus[questionId] = isCorrect ? 'correct' : 'wrong';
        
        const radio = element.querySelector('input[type="radio"]');
        if (radio) {
            radio.checked = true;
        }
        
        const nextBtn = document.getElementById('nextBtn_' + questionNum);
        if (nextBtn) {
            nextBtn.disabled = false;
        }
        
        if (questionNum === totalQuestions) {
            const showBtn = document.getElementById('showResultBtn');
            if (showBtn) {
                const answered = Object.keys(questionStatus).length;
                if (answered === totalQuestions) {
                    showBtn.disabled = false;
                }
            }
        }
        
        updateProgress();
    }

    // =============================================
    // UPDATE PROGRESS
    // =============================================
    function updateProgress() {
        const answered = Object.keys(questionStatus).length;
        const percentage = totalQuestions > 0 ? Math.round((answered / totalQuestions) * 100) : 0;
        
        document.getElementById('answeredCount').textContent = answered;
        document.getElementById('progressBar').style.width = percentage + '%';
    }

    // =============================================
    // SHOW FINAL RESULT
    // =============================================
    function showFinalResult() {
        const total = totalQuestions;
        const correct = correctCount;
        const wrong = wrongCount;
        const percentage = Math.round((correct / total) * 100);
        
        let emoji, title, subtitle, color;
        
        if (percentage >= 80) {
            emoji = '🏆';
            title = 'Excellent! 🎉';
            subtitle = 'You are a star! Keep it up!';
            color = '#28a745';
        } else if (percentage >= 60) {
            emoji = '🌟';
            title = 'Good Job! 👍';
            subtitle = 'You did well! Practice more to improve!';
            color = '#ffc107';
        } else if (percentage >= 40) {
            emoji = '📚';
            title = 'Keep Trying! 💪';
            subtitle = 'Practice makes perfect! You can do better!';
            color = '#fd7e14';
        } else {
            emoji = '😊';
            title = 'Need More Practice! 📖';
            subtitle = "Don't worry! Review the lessons and try again!";
            color = '#dc3545';
        }
        
        const resultHTML = `
            <div class="emoji">${emoji}</div>
            <div class="result-title" style="color: ${color};">${title}</div>
            <div class="result-subtitle">${subtitle}</div>
            
            <div class="result-stats">
                <div class="stat-item total">
                    <div class="stat-number">${total}</div>
                    <div class="stat-label">Total</div>
                </div>
                <div class="stat-item correct">
                    <div class="stat-number">${correct}</div>
                    <div class="stat-label">Correct</div>
                </div>
                <div class="stat-item wrong">
                    <div class="stat-number">${wrong}</div>
                    <div class="stat-label">Wrong</div>
                </div>
            </div>
            
            <div class="percentage-text" style="color: ${color};">${percentage}%</div>
            
            <div class="result-btns">
                <a href="${window.location.href}" class="result-btn retry">
                    <i class="fas fa-redo"></i> Try Again
                </a>
                <a href="<?= base_url('practice') ?>" class="result-btn home">
                    <i class="fas fa-home"></i> Back
                </a>
            </div>
        `;
        
        document.getElementById('resultCard').innerHTML = resultHTML;
        document.getElementById('finalResult').style.display = 'block';
        
        document.querySelectorAll('.question-item').forEach(item => {
            item.style.display = 'none';
        });
        
        document.getElementById('finalResult').scrollIntoView({ behavior: 'smooth' });
    }

    // =============================================
    // NAVIGATION
    // =============================================
    function goToQuestion(num) {
        if (num < 1 || num > totalQuestions) return;
        
        document.querySelectorAll('.question-item').forEach(item => {
            item.style.display = 'none';
        });
        
        const target = document.querySelector(`.question-item[data-question="${num}"]`);
        if (target) {
            target.style.display = 'block';
        }
        
        currentQuestion = num;
        window.scrollTo({top: 0, behavior: 'smooth'});
    }

    function nextQuestion(num) {
        if (num < totalQuestions) {
            goToQuestion(num + 1);
        }
    }

    // =============================================
    // INITIALIZE
    // =============================================
    document.addEventListener('DOMContentLoaded', function() {
        goToQuestion(1);
        updateProgress();
    });

    // =============================================
    // KEYBOARD NAVIGATION
    // =============================================
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            const prevNum = currentQuestion - 1;
            if (prevNum >= 1) {
                goToQuestion(prevNum);
            }
        } else if (e.key === 'ArrowRight') {
            e.preventDefault();
            const nextBtn = document.getElementById('nextBtn_' + currentQuestion);
            if (nextBtn && !nextBtn.disabled) {
                nextQuestion(currentQuestion);
            }
        }
    });
</script>