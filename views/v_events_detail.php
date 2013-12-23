
        <div class="content">
            <!-- breadcrumb navigation -->
            <nav class="breadcrumb_navigation">
                <ul>
                    <li class="breadcrumb_root">
                        <a href="/">Home</a>
                        <ul>
                            <li class="breadcrumb_child">
                                <a href="/events">Event Directory</a>
                                <ul>
                                    <li class="breadcrumb_child">Event Detail</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- end breadcrumb navigation -->             
                    
            <!-- Detail -->
 
            <?php if ($canUpdateEvent): ?>
                <p/>
                <div class='edit-link'>
                    <form method='POST' action='/events/edit'>
                        <input type="hidden" name="event_id" value="<?=$event->event_id?>" >
                        <input type='submit' value='Edit Event' class='detail-button'/>
                    </form>
                </div>
            <?php endif; ?>

            <h2 class="before-detail">Event</h2>

            <hr class="clearme"/>

            <section class="detail-section event-detail">
                <ul>
                    <li class="image">
                        <div class="image-div">
                            <img src="<?=$event->image_url?>" alt="" />
                        </div>
                    </li>

                    <li class="name"><?=$event->name?></li>

                    <li class="label">Presented by</li>
                    <li class="organization">
                        <a href="/organizations/detail/<?=$event->organization->organization_id?>"><?=$event->organization->name?></a>
                    </li>

                    <li class="description"><?=$event->description?></li>

                    <?php if ($event->admission_info): ?>
                    <li class="label">Admission Information</li>
                    <li class="admission-info"><?=$event->admission_info?></li>
                    <?php endif; ?>

                    <?php if ($event->website): ?>
                    <li class="website website-button">
                        <a href="<?=$event->website?>">Event Website</a>
                    </li>
                    <?php endif; ?>

                    <?php if ($event->organization->email): ?>
                    <li class="label">Email</li>
                    <li class="email">
                        <a href="mailto:<?=$event->organization->email?>"><?=$event->organization->email?></a>
                    </li>
                    <?php endif; ?>

                    <?php if ($event->organization->phone): ?>
                    <li class="label">Phone</li>
                    <li class="phone"><?=$event->organization->phone?></li>
                    <?php endif; ?>
                </ul>

                <?php if ($event->shows): ?>
                    <?php include("includes/event-show-list.php"); ?>
                <?php endif; ?>
                
                <hr class="clearme"/>
            </section>    

            <?php if ($canAddShow): ?>
                <p/>
                <div class='add-child-link'>
                    <form method='POST' action='/events/addshow'>
                        <input type="hidden" name="event_id" value="<?=$event->event_id?>" >
                        <input type="hidden" name="from_event" value="1" >
                        <input type='submit' value='Add Show' class='detail-button'/>
                    </form>
                </div>
            <?php endif; ?>

        </div>