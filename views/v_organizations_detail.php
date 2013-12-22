        <div class="content">
            <!-- breadcrumb navigation -->
            <nav class="breadcrumb_navigation">
                <ul>
                    <li class="breadcrumb_root">
                        <a href="/">Home</a>
                        <ul>
                            <li class="breadcrumb_child">
                                <a href="/organizations">Organization Directory</a>
                                <ul>
                                    <li class="breadcrumb_child">Organization Detail</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- end breadcrumb navigation -->             
            
            <h2 class="before-detail">Organization</h2>
            
            <section class="detail-section">
                <ul>
                    <li class="image">
                        <div class="image-div">
                            <img src="<?=$organization->firstImage?>" alt="" />
                        </div>
                    </li>
                    <li class="name"><?=$organization->name?></li>

                    <?php if ($organization->director): ?>
                    <li class="label">Director</li>
                    <li class="director"><?=$organization->director?></li>
                    <?php endif; ?>

                    <li class="description"><?=$organization->description?></li>
                    <li class="label">Address</li>
                    <li class="address"><?=$organization->address->street?></li>
                    <li class="address"><?=$organization->address->city?>, <?=$organization->address->state?> <?=$organization->address->zipcode?></li>
                    
                    <?php if ($organization->website): ?>
                    <li class="label">Website</li>
                    <li class="website">
                        <a href="<?=$organization->website?>"><?=$organization->website?></a>
                    </li>
                    <?php endif; ?>

                    <?php if ($organization->email): ?>
                    <li class="label">Email</li>
                    <li class="email">
                        <a href="mailto:<?=$organization->email?>"><?=$organization->email?></a>
                    </li>
                    <?php endif; ?>

                    <?php if ($organization->phone): ?>
                    <li class="label">Phone</li>
                    <li class="website"><?=$organization->phone?></li>
                    <?php endif; ?>

                </ul>
                <hr class="clearme"/>

            </section>

            <?php if (isset($events)): ?>
                <h3>Organization Events</h3>
                <section class="event-summaries">
                    <?php echo $events; ?>
                </section>
            <?php endif; ?>

            <?php if ($user): ?>
                <?php if ($canAddEvent): ?>
                    <p/>
                    <div class='add-event-link'>
                        <form method='POST' action='/events/add'>
                            <input type="hidden" name="organization_id" value="<?=$organization->organization_id?>" >
                            <input type="hidden" name="from_organization" value="1" >
                            <input type='submit' value='Add Event' class='detail-button'/>
                        </form>
                    </div>
                <?php endif; ?>

                <?php if ($canUpdateOrganization): ?>
                    <p/>
                    <div class='edit-organization-link'>
                        <form method='POST' action='/organizations/edit'>
                            <input type="hidden" name="organization_id" value="<?=$organization->organization_id?>" >
                            <input type='submit' value='Edit Organization' class='detail-button'/>
                        </form>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
