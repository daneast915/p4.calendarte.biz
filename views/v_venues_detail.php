
        <div class="content">

            <!-- breadcrumb navigation -->
            <nav class="breadcrumb_navigation">
                <ul>
                    <li class="breadcrumb_root">
                        <a href="index.php">Home</a>
                        <ul>
                            <li class="breadcrumb_child">
                                <a href="\venues">Venue Directory</a>
                                <ul>
                                    <li class="breadcrumb_child">Venue Detail</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- end breadcrumb navigation -->             

            <!-- Detail -->
            <h2 class="before-detail">Venue</h2>

            <section class="detail-section">
                <ul>
                    <li class="image">
                        <div class="image-div">
                            <img src="<?=$venue->firstImage?>" alt="" />
                        </div>
                    </li>
                    
                    <li class="name"><?=$venue->name?></li>
                    <li class="description"><?=$venue->description?></li>
                    <li class="label">Address</li>
                    <li class="address"><?=$venue->address->street?></li>
                    <li class="address"><?=$venue->address->city?>, <?=$venue->address->state?> <?=$venue->address->zipcode?></li>

                    <?php if ($venue->website): ?>
                    <li class="label">Website</li>
                    <li class="website">
                        <a href="<?=$venue->website?>"><?=$venue->website?></a>
                    </li>
                    <?php endif; ?>

                    <?php if ($venue->email): ?>
                    <li class="label">Email</li>
                    <li class="email">
                        <a href="mailto:<?=$venue->email?>"><?=$venue->email?></a>
                    </li>
                    <?php endif; ?>

                    <?php if ($venue->phone): ?>
                    <li class="label">Phone</li>
                    <li class="phone"><?=$venue->phone?></li>
                    <?php endif; ?>

                    <?php if ($venue->accessibilityInfo): ?>
                    <li class="label">Accessibility Information</li>
                    <li class="accessibility-info"><?=$venue->accessibilityInfo?></li>
                    <?php endif; ?>
                </ul>
                <hr class="clearme"/>
            </section>
        </div>

</section>