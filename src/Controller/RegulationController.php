<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegulationController extends AbstractController
{
    /**
     * @Route("/regulations", name="regulations_list")
     */
    public function list(): Response
    {
        // Here you would typically fetch the relevant data protection regulations
        // that your tool helps companies comply with.
        // This could come from a database, configuration files, or an external API.

        // For this example, I'll create a static array representing some key
        // aspects of data protection regulations, inspired by the Hackathon context.

        $dataProtectionRegulations = [
            [
                'title' => 'Principes de la Protection des Données Personnelles',
                'description' => 'Aperçu des principes fondamentaux régissant le traitement des données personnelles.',
                'details' => [
                    'Consentement: Le traitement des données personnelles doit être basé sur le consentement libre, spécifique, éclairé et univoque de la personne concernée.',
                    'Licéité, Loyauté et Transparence: Les données doivent être traitées de manière licite, loyale et transparente au regard de la personne concernée.',
                    'Limitation des Finalités: Les données ne doivent être collectées que pour des finalités déterminées, explicites et légitimes, et ne pas être traitées ultérieurement d\'une manière incompatible avec ces finalités.',
                    'Minimisation des Données: Les données collectées doivent être adéquates, pertinentes et limitées à ce qui est nécessaire au regard des finalités pour lesquelles elles sont traitées.',
                    'Exactitude: Les données doivent être exactes et, si nécessaire, tenues à jour. Toutes les mesures raisonnables doivent être prises pour que les données inexactes soient effacées ou rectifiées sans tarder.',
                    'Limitation de la Conservation: Les données doivent être conservées sous une forme permettant l\'identification des personnes concernées pendant une durée n\'excédant pas celle nécessaire au regard des finalités pour lesquelles elles sont traitées.',
                    'Intégrité et Confidentialité: Les données doivent être traitées de manière à garantir une sécurité appropriée, y compris la protection contre le traitement non autorisé ou illicite et contre la perte, la destruction ou les dommages d\'origine accidentelle, à l\'aide de mesures techniques ou organisationnelles appropriées.',
                    'Responsabilité: Le responsable du traitement est responsable du respect de ces principes et doit être en mesure de démontrer cette conformité.',
                ],
            ],
            [
                'title' => 'Droits des Personnes Concernées',
                'description' => 'Présentation des droits dont disposent les individus concernant leurs données personnelles.',
                'details' => [
                    'Droit d\'Accès: La personne concernée a le droit d\'obtenir du responsable du traitement la confirmation que des données à caractère personnel la concernant sont ou ne sont pas traitées et, lorsqu\'elles le sont, l\'accès auxdites données ainsi qu\'à certaines informations.',
                    'Droit de Rectification: La personne concernée a le droit d\'obtenir du responsable du traitement, dans les meilleurs délais, la rectification des données à caractère personnel la concernant qui sont inexactes.',
                    'Droit à l\'Effacement ("droit à l\'oubli"): La personne concernée a le droit d\'obtenir du responsable du traitement l\'effacement, dans les meilleurs délais, de données à caractère personnel la concernant dans certains cas.',
                    'Droit à la Limitation du Traitement: La personne concernée a le droit d\'obtenir du responsable du traitement la limitation du traitement dans certains cas.',
                    'Droit à la Portabilité des Données: La personne concernée a le droit de recevoir les données à caractère personnel la concernant qu\'elle a fournies à un responsable du traitement, dans un format structuré, couramment utilisé et lisible par machine, et a le droit de transmettre ces données à un autre responsable du traitement sans que le responsable du traitement auquel les données à caractère personnel ont été communiquées y fasse obstacle.',
                    'Droit d\'Opposition: La personne concernée a le droit de s\'opposer à tout moment, pour des raisons tenant à sa situation particulière, au traitement des données à caractère personnel la concernant.',
                    'Droit de ne pas être soumis à une décision fondée exclusivement sur un traitement automatisé, y compris le profilage.',
                ],
            ],
            [
                'title' => 'Sécurité des Données',
                'description' => 'Exigences relatives à la mise en œuvre de mesures de sécurité appropriées.',
                'details' => [
                    'Obligation de mettre en œuvre des mesures techniques et organisationnelles appropriées pour garantir un niveau de sécurité adapté au risque.',
                    'Considération de l\'état des connaissances, des coûts de mise en œuvre et de la nature, de la portée, du contexte et des finalités du traitement ainsi que des risques, dont le degré de probabilité et de gravité varie, pour les droits et libertés des personnes physiques.',
                    'Mesures incluant, entre autres, la pseudonymisation et le chiffrement des données à caractère personnel.',
                    'Capacité à assurer la confidentialité, l\'intégrité, la disponibilité et la résilience constantes des systèmes et des services de traitement.',
                    'Capacité à rétablir la disponibilité des données à caractère personnel et l\'accès à celles-ci dans des délais appropriés en cas d\'incident physique ou technique.',
                    'Processus visant à tester, à analyser et à évaluer régulièrement l\'efficacité des mesures techniques et organisationnelles pour assurer la sécurité du traitement.',
                ],
            ],
            // Add more key regulatory areas as needed for your tool
            [
                'title' => 'Obligations en cas de Violation de Données',
                'description' => 'Procédures à suivre en cas de violation de la sécurité entraînant la destruction, la perte, l\'altération, la divulgation non autorisée de données personnelles.',
                'details' => [
                    'Notification de la violation de données à l\'autorité de contrôle compétente dans les meilleurs délais et, si possible, au plus tard 72 heures après en avoir pris connaissance, à moins que la violation en question ne soit pas susceptible d\'engendrer un risque pour les droits et libertés des personnes physiques.',
                    'Communication de la violation de données à la personne concernée dans les meilleurs délais si la violation est susceptible d\'engendrer un risque élevé pour les droits et libertés des personnes physiques.',
                    'Documentation de toute violation de données à caractère personnel, y compris les faits relatifs à la violation, ses effets et les mesures correctives prises.',
                ],
            ],
        ];

        return $this->render('regulation/list.html.twig', [
            'regulations' => $dataProtectionRegulations,
        ]);
    }
}