<!-- Dynamic Competition Details Page -->
<section class="hero-section-competion inner-padding">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="status-badge">
                    <i class="fas fa-circle"></i> <?= $competition->hero_status_badge ?? 'Registrations Open' ?>
                </span>
                <h1 class="hero-title">
                    <?= $competition->hero_title ?? $competition->title ?>
                    <span><?= explode(' ', $competition->hero_title ?? $competition->title)[0] ?? '' ?></span>
                </h1>
                <p><?= $competition->hero_description ?? $competition->description ?></p>
                <div class="date-box">
                    <?php if($competition->registration_deadline): ?>
                    <div class="date-row">
                        📝 Last Date to Register: <strong><?= date('F j, Y', strtotime($competition->registration_deadline)) ?></strong>
                    </div>
                    <?php endif; ?>
                    <?php if($competition->submission_deadline): ?>
                    <div class="date-row">
                        📤 Last Date to Submit: <strong><?= date('F j, Y', strtotime($competition->submission_deadline)) ?></strong>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="mb-4">
                    <a href="<?php echo base_url('register'); ?>" class="theme-btn"> Register Now → </a>
                    <a href="<?php echo base_url('register'); ?>" class="border-btn"> Read Rules, Guidelines & Eligibility → </a>
                </div>
                <div class="info-tags">
                    <span>👶 KG – Grade 12</span>
                    <span>🌍 India & International</span>
                    <span>🎨 5 Grade Categories</span>
                    <span>🏆 Trophies & Certificates</span>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="poster-card">
                    <?php if($competition->poster_card_image): ?>
                    <div class="poster-icon">
                        <img src="<?= base_url('uploads/competitions/'.$competition->poster_card_image) ?>" style="height: 100px">
                    </div>
                    <?php else: ?>
                    <div class="poster-icon"><img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/1f3a8.svg" style="height: 100px"></div>
                    <?php endif; ?>
                    <h3><?= $competition->poster_card_title ?? $competition->title ?></h3>
                    <p><?= $competition->poster_card_description ?? 'Create. Imagine. Win Big.' ?></p>
                    <div class="grade-badges">
                        <span>KG</span>
                        <span>Gr 1–3</span>
                        <span>Gr 4–6</span>
                        <span>Gr 7–9</span>
                        <span>Gr 10–12</span>
                    </div>
                    <div class="price-box">
                        <div class="row g-0">
                            <div class="col-md-6">
                                <div class="price-label">India</div>
                                <div class="price"><?= $competition->price_india ?? '₹500' ?></div>
                                <div class="price-sub">Per student</div>
                            </div>
                            <div class="col-md-6">
                                <div class="price-label">International</div>
                                <div class="price"><?= $competition->price_international ?? '$10' ?></div>
                                <div class="price-sub">Per student</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Counter Section -->
<?php if(!empty($competition->counter_data)): ?>
<section class="counter-section section-padding">
    <div class="snake-shape float-bob-y">
        <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/counter/snake.png" alt="shape-img">
    </div>
    <div class="sun-shape float-bob-x">
        <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/counter/sun.png" alt="shape-img">
    </div>
    <div class="counter-bg"></div>
    <div class="container">
        <div class="row g-4">
            <?php foreach($competition->counter_data as $counter): ?>
            <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay=".2s">
                <div class="counter-items">
                    <div class="counter-box">
                        <div class="count">
                            <h3 class="btss"><?= $counter['text'] ?? '' ?></h3>
                        </div>
                        <p><?= $counter['subtext'] ?? '' ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- About Section - Features -->
<section class="classes-section breadcrumb-classes section-padding fix">
    <div class="container">
        <div class="section-title text-center">
            <span class="sub-title wow fadeInUp">About the Competition</span>
            <h2 class="char-animation"> Create & <span>Let</span> Them Shine</h2>
            <p><?= $competition->description ?? 'EduJunior\'s Online Poster Making Competition celebrates creativity, expression, and artistic talent.' ?></p>
        </div>
        <div class="row g-4">
            <?php if(!empty($competition->features)): ?>
                <?php foreach($competition->features as $feature): ?>
                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInRight" data-wow-delay=".5s">
                    <div class="classes-box-item mt-0 box-shadow" style="padding: 20px;">
                        <?php if(!empty($feature['icon_image'])): ?>
                        <div class="pm-about-icon">
                            <img src="<?= base_url('uploads/features/'.$feature['icon_image']) ?>" style="height: 50px; width: 50px; object-fit: contain;">
                        </div>
                        <?php else: ?>
                        <div class="pm-about-icon">
                            <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/1f3a8.svg" style="height: 50px;">
                        </div>
                        <?php endif; ?>
                        <h3 style="font-size: 26px;"><?= $feature['title'] ?? '' ?></h3>
                        <p><?= $feature['description'] ?? '' ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Default features if no data -->
                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInRight" data-wow-delay=".5s">
                    <div class="classes-box-item mt-0 box-shadow" style="padding: 20px;">
                        <div class="pm-about-icon"><img src="assets/img/1f3a8.svg"></div>
                        <h3 style="font-size: 26px;">Hand-Made Posters Only</h3>
                        <p>Only original, hand-made posters are accepted. Use any medium — watercolours, crayons, sketch pens, acrylic, or oil pastels.</p>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInRight" data-wow-delay=".5s">
                    <div class="classes-box-item mt-0 box-shadow" style="padding: 20px;">
                        <div class="pm-about-icon"><img src="assets/img/1f4f8.svg"></div>
                        <h3 style="font-size: 26px;">Photo Submission</h3>
                        <p>Only original, hand-made posters are accepted. Use any medium — watercolours, crayons, sketch pens, acrylic, or oil pastels.</p>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInRight" data-wow-delay=".5s">
                    <div class="classes-box-item mt-0 box-shadow" style="padding: 20px;">
                        <div class="pm-about-icon"><img src="assets/img/1f30d.svg"></div>
                        <h3 style="font-size: 26px;">India & International</h3>
                        <p>Only original, hand-made posters are accepted. Use any medium — watercolours, crayons, sketch pens, acrylic, or oil pastels.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Categories & Themes Section -->
<?php if(!empty($competition->categories)): ?>
<section class="category-section classes-section breadcrumb-classes section-padding fix" style="background: #fff">
    <div class="container">
        <div class="section-title text-center">
            <span class="sub-title wow fadeInUp">Grade-wise Themes</span>
            <h2 class="char-animation"> Competition <span> Categories </span> & Themes</h2>
            <p>Each grade group has 2 themes — choose any one. Clearly mention your chosen theme at the top of your poster.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-12">
                <?php foreach($competition->categories as $category): ?>
                <div class="category-card mb-4">
                    <div class="category-header <?= $category['color'] ?? 'category-pink' ?> d-flex align-items-center">
                        <span class="category-badge"><?= $category['badge'] ?? '' ?></span>
                        <h4 class="mb-0 ms-3"><?= $category['title'] ?? '' ?></h4>
                    </div>
                    <div class="category-body">
                        <div class="row g-3">
                            <?php if(!empty($category['themes'])): ?>
                                <?php foreach($category['themes'] as $theme): ?>
                                <div class="col-md-6">
                                    <div class="theme-card">
                                        <h5><?= ($theme['icon'] ?? '') . ' ' . ($theme['title'] ?? '') ?></h5>
                                        <p><?= $theme['description'] ?? '' ?></p>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <div class="theme-note">
                            ✏️ Choose any one theme for your poster.
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Submission Requirements -->
<?php if(!empty($competition->submission_requirements)): ?>
<section class="classes-section breadcrumb-classes section-padding fix">
    <div class="container">
        <div class="section-title text-center">
            <span class="sub-title wow fadeInUp">Submission Requirements</span>
            <h2 class="char-animation"> What <span> to </span> Submit</h2>
            <p>Everything you need to send along with your poster entry.</p>
        </div>
        <div class="row g-4">
            <?php foreach($competition->submission_requirements as $requirement): ?>
            <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInRight" data-wow-delay=".5s">
                <div class="classes-box-item mt-0 box-shadow" style="padding: 20px;">
                    <div class="pm-about-icon">
                        <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/<?= $requirement['icon'] ?? '1f5bc.svg' ?>" style="height: 50px;">
                    </div>
                    <h3 style="font-size: 26px;"><?= $requirement['title'] ?? '' ?></h3>
                    <p><?= $requirement['description'] ?? '' ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Prizes Section -->
<?php if(!empty($competition->prizes)): ?>
<section class="awards-section classes-section breadcrumb-classes section-padding fix" style="background: #fff">
    <div class="container">
        <div class="section-title text-center">
            <span class="sub-title wow fadeInUp">Prizes & Honors</span>
            <h2 class="char-animation"> What <span> You </span> Can Win</h2>
            <p>Every participant is recognised. Winners are celebrated with physical awards delivered to their door!</p>
        </div>
        <div class="row g-4">
            <?php foreach($competition->prizes as $prize): ?>
            <div class="col-lg-3 col-md-6">
                <div class="award-card <?= $prize['type'] ?? 'participant' ?>-card">
                    <div class="award-icon"><?= $prize['icon'] ?? '🏅' ?></div>
                    <h3><?= $prize['title'] ?? '' ?></h3>
                    <?php if(!empty($prize['items'])): ?>
                    <ul class="award-list">
                        <?php foreach($prize['items'] as $item): ?>
                        <li><?= $item ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- FAQs Section -->
<?php if(!empty($competition->faqs)): ?>
<section class="faq-section section-padding fix" style="background: #f15f25;">
    <div class="container">
        <div class="faq-wrapper">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="faq-tittle">
                        <div class="section-title">
                            <span class="sub-title wow fadeInUp">Got Questions?</span>
                            <h2 class="char-animation" style="color: #fff">
                                Frequently Asked Questions
                            </h2>
                            <p class="mt-3 mt-md-0 wow fadeInUp" data-wow-delay=".5s" style="color: #fff">
                                Find answers to commonly asked questions about the competition.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="faq-box-item">
                        <ul class="accordion-box">
                            <?php $count = 1; foreach($competition->faqs as $faq): ?>
                            <li class="accordion block <?= $count == 1 ? 'active-block' : '' ?> wow fadeInUp" data-wow-delay=".<?= $count * 2 ?>s">
                                <div class="acc-btn <?= $count == 1 ? 'active' : '' ?>">
                                    <?= $count ?>. <?= $faq['question'] ?? '' ?>
                                    <div class="icon far fa-plus-circle"></div>
                                </div>
                                <div class="acc-content <?= $count == 1 ? 'current' : '' ?>">
                                    <div class="content">
                                        <div class="text">
                                            <?= $faq['answer'] ?? '' ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php $count++; endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- How to Participate -->
<?php if(!empty($competition->how_to_participate)): ?>
<div class="program-section-two section-padding fix">
    <div class="container">
        <div class="section-title text-center">
            <span class="sub-title wow fadeInUp">Simple Process</span>
            <h2 class="char-animation"> How to <span> Participate?</span></h2>
            <p>Three simple steps — from registration to receiving your rewards.</p>
        </div>
        <div class="program-wrapper">
            <div class="row text-center">
                <?php foreach($competition->how_to_participate as $step): ?>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 wow fadeInLeft" data-wow-delay=".2s">
                    <div class="program-items">
                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/program/<?= $step['icon'] ?? 'icon1.svg' ?>" alt="icon-image">
                            </div>
                            <div class="program-waves">
                                <div class="waves wave-1"></div>
                                <div class="waves wave-2"></div>
                                <div class="waves wave-3"></div>
                            </div>
                            <div class="arrow-shape">
                                <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/program/arrow-right.png" alt="shape-image">
                            </div>
                        </div>
                        <div class="program-content">
                            <h3><?= $step['title'] ?? '' ?></h3>
                            <p><?= $step['description'] ?? '' ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>