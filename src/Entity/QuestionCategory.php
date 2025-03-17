<?php

namespace App\Entity;

enum QuestionCategory: string
{
    case Transparence = 'Transparence';
    case Consentement = 'Consentement';
    case SecuriteDesDonnees = 'Sécurité des Données';
    case GestionDesDonnees = 'Gestion des Données';
    case DroitsDesUtilisateurs = 'Droits des Utilisateurs';
    case PartageEtTransfertDesDonnees = 'Partage et Transfert des Données';
    case FormationEtSensibilisation = 'Formation et Sensibilisation';
    case ConformiteEtAudit = 'Conformité et Audit';
    case DelegueALaProtectionDesDonneesDPO = 'Délégué à la Protection des Données (DPO)';
    case DocumentationEtPreuves = 'Documentation et Preuves';
    case GestionDesRisques = 'Gestion des Risques';
    case ResponsabiliteEtGouvernance = 'Responsabilité et Gouvernance';
}
