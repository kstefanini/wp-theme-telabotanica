<?php
/**
 * Post
 */

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

      <?php if ( have_posts() ) : ?>
        <div class="layout-central-col">
          <div class="layout-wrapper">
            <?php while ( have_posts() ) : the_post(); ?>
              <aside class="layout-aside">
                <?php the_telabotanica_module('meta-news'); ?>
              </aside>
              <div class="layout-content">
                <?php the_telabotanica_module('breadcrumbs'); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'article' ); ?>>
                  <?php

                  if ( post_is_in_descendant_category( 'offres-emploi' ) && has_post_thumbnail() ) :
                    the_post_thumbnail( 'post-thumbnail', ['class' => 'article-thumbnail'] );
                  endif;

                  the_title( '<h1 class="article-title">', '</h1>' );

                  if ( post_is_in_descendant_category( 'evenements' ) ) :
                    the_telabotanica_module('event-dates', [
                      'modifiers' => get_field('image') ? 'absolute' : 'float-left'
                    ]);
                    if ( get_field('image') ) :
                      the_telabotanica_component('image');
                    endif;
                  endif;

                  if ( get_field('intro') ) :
                    the_telabotanica_component('intro', [
                      'text' => get_field('intro')
                    ]);
                  endif;

                  // OFFRE D'EMPLOI
                  if ( post_is_in_descendant_category( 'offres-emploi' ) ) :

                    if ( get_field('context') ) :
                      the_telabotanica_component('title', [
                        'title' => __( "Contexte", 'telabotanica' )
                      ]);
                      the_telabotanica_component('text', [
                        'text' => get_field('context')
                      ]);
                    endif;

                    if ( get_field('missions') ) :
                      the_telabotanica_component('title', [
                        'title' => __( "Missions", 'telabotanica' )
                      ]);
                      the_telabotanica_component('text', [
                        'text' => get_field('missions')
                      ]);
                    endif;

                    if ( get_field('profile') ) :
                      the_telabotanica_component('title', [
                        'title' => __( "Profil recherché", 'telabotanica' )
                      ]);
                      the_telabotanica_component('text', [
                        'text' => get_field('profile')
                      ]);
                    endif;

                    if ( get_field('conditions') ) :
                      the_telabotanica_component('title', [
                        'title' => __( "Poste et conditions", 'telabotanica' )
                      ]);
                      the_telabotanica_component('text', [
                        'text' => get_field('conditions')
                      ]);
                    endif;

                    if ( get_field('how_to_apply') ) :
                      the_telabotanica_component('title', [
                        'title' => __( "Modalités de candidature", 'telabotanica' )
                      ]);
                      the_telabotanica_component('text', [
                        'text' => get_field('how_to_apply')
                      ]);
                    endif;

                  endif; // FIN OFFRE D'EMPLOI

                  if ( get_field('description') ) :
                    the_telabotanica_component('text', [
                      'text' => get_field('description')
                    ]);
                  endif;

                  if ( !empty( get_the_content() ) ) :
                    the_telabotanica_component('text', [
                      'text' => apply_filters('the_content', get_the_content())
                    ]);
                  endif;

                  // EN KIOSQUE
                  if ( has_category('en-kiosque') ) :

                    if ( get_field('author') ) :
                      the_telabotanica_component('title', [
                        'title' => __( "L'auteur", 'telabotanica' )
                      ]);
                      the_telabotanica_component('text', [
                        'text' => get_field('author')
                      ]);
                    endif;

                    if ( get_field('references') ) :
                      the_telabotanica_component('title', [
                        'title' => __( "Informations pratiques", 'telabotanica' )
                      ]);
                      the_telabotanica_component('text', [
                        'text' => get_field('references')
                      ]);
                    endif;

                    if ( get_field('how_to_buy') ) :
                      the_telabotanica_component('title', [
                        'title' => __( "Comment se procurer l'ouvrage ?", 'telabotanica' )
                      ]);
                      the_telabotanica_component('text', [
                        'text' => get_field('how_to_buy')
                      ]);
                    endif;

                  endif; // FIN EN KIOSQUE

                  // Si la page utilise des composants
                  if( have_rows('components') ) :

                      // On boucle sur les composants
                      while ( have_rows('components') ) : the_row();

                        the_telabotanica_component(get_row_layout(), []);

                      endwhile;

                  endif;

                  // EVENEMENT OU OFFRES-EMPLOI
                  if ( post_is_in_descendant_category( 'evenements' ) || post_is_in_descendant_category( 'offres-emploi' )) :

                    $info_items = [];

                    $info_items[] = [
                      'title' => 'Adresse',
                      'text' => get_field('place')->value
                    ];

                    if ( post_is_in_descendant_category( 'evenements' )) :

                      $info_items[] = [
                        'title' => 'Tarif',
                        'text' => get_field('is_free') === true ? __( 'Gratuit', 'telabotanica') : get_field('prices')
                      ];

                    endif;

                    the_telabotanica_component('info', [
                      'items' => $info_items
                    ]);

                    the_telabotanica_component('map');

                  endif; // FIN EVENEMENT/OFFRE-EMPLOI

                  if ( get_field('contact_info') && !empty( get_field('contact_info')['contact'][0]['name'] ) ) {
                    the_telabotanica_component('contact', get_field('contact_info')['contact'][0]);
                  }
                  ?>
                </article>
              </div>
            <?php endwhile; ?>
          </div>
        </div>
      <?php

      comments_template();

      endif; ?>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
