<section class="section-registration winer">
  <div class="container">
    <div class="section-title">
      <h2>Hall of <span>Frame</span> 2025-26</h2>
      <p>Celebrating the outstanding achievements of our young champions! The Hall of Fame 2025–26 recognizes students who have demonstrated exceptional talent, creativity, dedication, and excellence across various competitions and Olympiads. Their remarkable accomplishments inspire others to dream big, work hard, and strive for success.</p>
    </div>
    
    <div class="row justify-content-center">
      <div class="col-lg-12"> 
        <div class="team-section-two">
          <div class="container">
            <div class="row g-4">
              <?php if (!empty($winners)): ?>
                <?php foreach ($winners as $winner): ?>
                  <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInRight" data-wow-delay=".5s">
                    <div class="team-box">
                      <div class="team-image">
                        <img src="<?= base_url('assets/winners/' . ($winner->image ?? 'default.jpg')) ?>" alt="<?= esc($winner->name) ?>">
                      </div>
                      <div class="team-content">
                        <h2>
                          <a href="team-details.html"><?= esc($winner->name) ?></a>
                        </h2>
                        <p><?= esc($winner->title) ?></p>
                        <small class="text-muted"><?= esc($winner->category) ?></small>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <div class="col-12 text-center">
                  <h4>No winners found</h4>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>