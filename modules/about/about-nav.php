<?php
$banner_image = get_sub_field('banner_image');
$title = get_sub_field('title');
$nav_items = [];
$about_sections = get_field('about_sections');

if ($about_sections) :
    $index = 1;
    foreach ($about_sections as $section) :
        $layout = $section['acf_fc_layout'];
        $section_title = '';
        
        switch ($layout) {
            case 'publication':
                $section_title = $section['section_title'] ?? 'Our Publication';
                break;
            case 'team':
                $section_title = $section['section_title'] ?? 'Our Team';
                break;
            case 'readership':
                $section_title = $section['section_title'] ?? 'Readership & Distribution';
                break;
            case 'contact':
                $section_title = $section['title'] ?? 'Contact Us';
                break;
        }
        
        if (!empty($section_title)) {
            $nav_items[] = [
                'title' => $section_title,
                'id' => 'about-' . $index
            ];
        }
        
        $index++;
    endforeach;
endif;
?>
<?php get_template_part('modules/common/breadcrumb'); ?>

<?php if (!empty($nav_items)): ?>
<div class="main-nav-mb">
    <div class="container">
        <div class="toggle">
            <p class="category">Danh mục</p><em class="lnr lnr-chevron-down"></em>
        </div>
        <ul class="about-nav">
            <?php foreach ($nav_items as $nav_index => $item): ?>
            <li<?php echo $nav_index === 0 ? ' class="active"' : ''; ?>>
                <a href="#<?= $item['id'] ?>" data-section="<?= $item['id'] ?>"><?= $item['title'] ?></a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<style>
/* About Nav Active State */
.main-nav-mb .about-nav li a {
    position: relative;
    display: inline-block;
    padding: 10px 5px;
    color: var(--text-gray81-color, #818181);
    text-decoration: none;
    transition: all 0.3s ease;
}

.main-nav-mb .about-nav li a::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 3px;
    background: var(--primary-color, #3C0000);
    transition: width 0.3s ease;
}

.main-nav-mb .about-nav li a:hover,
.main-nav-mb .about-nav li.active a {
    color: var(--primary-color, #3C0000);
    font-weight: 600;
}

.main-nav-mb .about-nav li.active a::after {
    width: 100%;
}

@media (min-width: 1024px) {
    .main-nav-mb .about-nav {
        border-bottom: 1px solid #e1e1e1;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const aboutNavLinks = document.querySelectorAll('.about-nav li a[data-section]');
    const sections = [];
    const headerHeight = document.querySelector('header') ? document.querySelector('header').offsetHeight : 0;
    const navMb = document.querySelector('.main-nav-mb');
    const navMbHeight = navMb ? navMb.offsetHeight : 0;
    const offset = headerHeight + navMbHeight + 50; // Extra offset for better UX

    // Collect all sections
    aboutNavLinks.forEach(function(link) {
        const sectionId = link.getAttribute('data-section');
        const section = document.getElementById(sectionId);
        if (section) {
            sections.push({
                id: sectionId,
                element: section,
                link: link
            });
        }
    });

    // Function to update active nav item
    function updateActiveNav() {
        const scrollPosition = window.scrollY + offset;
        
        let currentSection = null;
        
        // Find which section is currently in view
        sections.forEach(function(sectionData) {
            const sectionTop = sectionData.element.offsetTop;
            const sectionBottom = sectionTop + sectionData.element.offsetHeight;
            
            if (scrollPosition >= sectionTop && scrollPosition < sectionBottom) {
                currentSection = sectionData;
            }
        });

        // If no section found and we're at the top, activate first
        if (!currentSection && sections.length > 0 && scrollPosition < sections[0].element.offsetTop) {
            currentSection = sections[0];
        }

        // If we're past all sections, activate the last one
        if (!currentSection && sections.length > 0) {
            const lastSection = sections[sections.length - 1];
            if (scrollPosition >= lastSection.element.offsetTop) {
                currentSection = lastSection;
            }
        }

        // Update active states
        if (currentSection) {
            aboutNavLinks.forEach(function(link) {
                link.parentElement.classList.remove('active');
            });
            currentSection.link.parentElement.classList.add('active');
        }
    }

    // Smooth scroll to section on click
    aboutNavLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const sectionId = this.getAttribute('data-section');
            const targetSection = document.getElementById(sectionId);
            
            if (targetSection) {
                const targetPosition = targetSection.offsetTop - headerHeight - navMbHeight + 10;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });

                // Update active state immediately on click
                aboutNavLinks.forEach(function(navLink) {
                    navLink.parentElement.classList.remove('active');
                });
                this.parentElement.classList.add('active');

                // Close mobile menu if open
                const navElement = document.querySelector('.main-nav-mb .about-nav');
                const toggleElement = document.querySelector('.main-nav-mb .toggle');
                if (window.innerWidth <= 1024 && navElement) {
                    navElement.style.display = 'none';
                    if (toggleElement) {
                        toggleElement.classList.remove('active');
                    }
                    // Reset for next toggle
                    setTimeout(function() {
                        navElement.style.display = '';
                    }, 100);
                }
            }
        });
    });

    // Throttle scroll event for better performance
    let ticking = false;
    window.addEventListener('scroll', function() {
        if (!ticking) {
            window.requestAnimationFrame(function() {
                updateActiveNav();
                ticking = false;
            });
            ticking = true;
        }
    });

    // Initial check
    updateActiveNav();
});
</script>
<?php endif; ?>