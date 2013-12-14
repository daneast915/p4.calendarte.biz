
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
            <h2 class="before-detail">Event</h2>

            <section class="detail-section event-detail">
                <ul>
                    <li class="image">
                        <div class="image-div">
                            <img src="<?=$event->firstImage?>" alt="" />
                        </div>
                    </li>

                    <li class="name"><?=$event->name?></li>

                    <li class="label">Presented by</li>
                    <li class="organization">
                        <a href="/organizations/detail/<?=$event->organization->id?>"><?=$event->organization->name?></a>
                    </li>

                    <li class="description"><?=$event->description?></li>

                    <?php if ($event->admissionInfo): ?>
                    <li class="label">Admission Information</li>
                    <li class="admission-info"><?=$event->admissionInfo?></li>
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

                <table class="show-list">
                    <thead>
                        <tr>
                            <th>Date/Time</th>
                            <th>Location</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($event->shows as $show): ?>

                        <tr>
                            <td class="date-time">
                                <?=$show->shortDay?>, <?=$show->shortDate?> - <?=$show->timeOfDay?>
                            </td>
                            <td class="location">
                                <a href="/venues/detail/<?=$show->venue->id?>"><?=$show->venue->name?></a>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                    </tbody>
                </table>
                
                <hr class="clearme"/>
            </section>    

        </div>