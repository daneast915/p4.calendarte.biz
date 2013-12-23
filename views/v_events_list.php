
    <section class="event-summaries">

        <?php foreach ($events as $event): ?>
            <article class="event-summary">
                <ul>
                    <li class="image">
                        <div class="image-div">
                            <img src="<?=$event->image_url?>" alt="" />
                        </div>
                    </li>
                
                    <li class="name">
                        <a href="/events/detail/<?=$event->event_id?>">
                            <?=$event->name?>
                        </a>
                    </li>
                    <li class="organization">
                        Presented by 
                        <a href="/organizations/detail/<?=$event->organization->organization_id?>">
                            <?=$event->organization->name?>
                        </a>
                    </li>

                    <?php if ($event->admission_info): ?>
                    <li class="label">Admission Information</li>
                    <li class="admission-info"><?=$event->admission_info?></li>
                    <?php endif; ?>                   
                </ul>
                
                <?php if ($event->shows): ?>
                    <?php include("includes/event-show-list.php"); ?>
                <?php endif; ?>                   

                <hr class="clearme"/>
            </article>
            
        <?php endforeach; ?>

    </section>
