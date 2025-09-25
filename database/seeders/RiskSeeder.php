<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RiskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Ensure Unit Coordinator user exists and use their id as creator
        $unitCoordinatorEmail = 'unit.coordinator@gmail.com';
        $unitUser = DB::table('users')->where('email', $unitCoordinatorEmail)->first();
        if ($unitUser) {
            $creatorId = $unitUser->id;
        } else {
            // create a basic user record if not present
            $creatorId = DB::table('users')->insertGetId([
                'name' => 'Unit Coordinator',
                'email' => $unitCoordinatorEmail,
                'role' => 'unit_coordinator',
                'password' => Hash::make('password123'),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $risks = [
            [
                'id' => (string) Str::uuid(),
                'cluster' => 'Management',
                'unit' => 'Administration',
                'name' => 'Delayed contract staff payments affecting performance',
                'category' => 'Finance',
                'description' => 'Because of delayed payments to contract staff, possibly due to a tiered payment mechanism, contract staff performance may decrease. Impact: tiered payment mechanism.',
                'impact' => 'Tiered payment mechanism',
                'uc_c' => false,
                'status' => 'draft',
                'created_by' => $creatorId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => (string) Str::uuid(),
                'cluster' => 'Management',
                'unit' => 'Administration',
                'name' => 'Capitation reduction may lower financial revenue',
                'category' => 'Finance',
                'description' => 'Due to a reduction in capitation, credentialing/KBKP requirements may not be met causing financial revenue to decrease. Impact: credentialing/KBKP requirements not met.',
                'impact' => 'Credentialing/KBKP requirements not met',
                'uc_c' => false,
                'status' => 'draft',
                'created_by' => $creatorId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => (string) Str::uuid(),
                'cluster' => 'Management',
                'unit' => 'Health Center Management',
                'name' => 'Poor service reviews damaging reputation',
                'category' => 'Reputation',
                'description' => 'Because of poor evaluations of provided services, possibly due to suboptimal service quality, customer trust may decrease. Impact: staff performance not optimal.',
                'impact' => 'Staff performance not optimal',
                'uc_c' => false,
                'status' => 'draft',
                'created_by' => $creatorId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => (string) Str::uuid(),
                'cluster' => 'Management',
                'unit' => 'Resource Management',
                'name' => 'Incomplete personnel files disrupting administration',
                'category' => 'Operational',
                'description' => 'Because personnel files are incomplete (lost or not submitted), administrative processes in the puskesmas may be disrupted. Impact: personnel files borrowed and not reported to HR.',
                'impact' => 'Personnel files borrowed and not reported',
                'uc_c' => false,
                'status' => 'draft',
                'created_by' => $creatorId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => (string) Str::uuid(),
                'cluster' => 'Management',
                'unit' => 'Quality & Safety Management',
                'name' => 'Asset loss affecting service delivery',
                'category' => 'Operational',
                'description' => 'Because of asset loss, possibly due to theft or accidental disposal, service delivery may be affected. Impact: theft or accidental disposal.',
                'impact' => 'Theft or accidental disposal',
                'uc_c' => false,
                'status' => 'draft',
                'created_by' => $creatorId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // --- Cluster: Maternal & Child ---
            [
                'id' => (string) Str::uuid(),
                'cluster' => 'Maternal & Child',
                'unit' => 'Pregnancy, Delivery, Postpartum',
                'name' => 'Staff at risk of needle-stick during immunization',
                'category' => 'HR',
                'description' => 'Because staff experience needle-stick injuries during immunization administration, they may lose focus and recap needles with both hands, increasing the risk of infection transmission.',
                'impact' => 'Staff distracted; recapping needles with both hands',
                'uc_c' => false,
                'status' => 'draft',
                'created_by' => $creatorId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => (string) Str::uuid(),
                'cluster' => 'Maternal & Child',
                'unit' => 'Pregnancy, Delivery, Postpartum',
                'name' => 'Pregnant woman slips during ultrasound examination',
                'category' => 'Reputation',
                'description' => 'Because a pregnant woman slipped during an ultrasound exam, possibly due to a narrow bed or slippery floor, a fall may occur.',
                'impact' => 'Ultrasound bed too narrow or slippery floor',
                'uc_c' => false,
                'status' => 'draft',
                'created_by' => $creatorId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => (string) Str::uuid(),
                'cluster' => 'Maternal & Child',
                'unit' => 'Infants and Preschool Children',
                'name' => 'Adverse events following immunization (AEFI) in infants',
                'category' => 'HR',
                'description' => 'Because of an adverse reaction to a vaccine, the infant may develop fever and swelling at the injection site.',
                'impact' => 'Adverse reaction to administered vaccine',
                'uc_c' => false,
                'status' => 'draft',
                'created_by' => $creatorId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => (string) Str::uuid(),
                'cluster' => 'Maternal & Child',
                'unit' => 'Pregnancy, Delivery, Postpartum',
                'name' => 'Incorrect pregnancy age calculation',
                'category' => 'HR',
                'description' => 'Because staff miscalculate the pregnancy age, possibly because the patient forgot the date of last menstruation, the pregnancy age may be uncertain.',
                'impact' => 'Patient forgot date of last menstruation',
                'uc_c' => false,
                'status' => 'draft',
                'created_by' => $creatorId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => (string) Str::uuid(),
                'cluster' => 'Maternal & Child',
                'unit' => 'Infants and Preschool Children',
                'name' => 'Wrong vaccine type/dose causing AEFI',
                'category' => 'HR',
                'description' => 'Because the wrong vaccine type or dose was administered, possibly due to missing immunization history, an adverse event may occur in the infant after immunization.',
                'impact' => 'Missing immunization history/documentation',
                'uc_c' => false,
                'status' => 'draft',
                'created_by' => $creatorId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // --- Cluster: Adults & Elderly ---
            [
                'id' => (string) Str::uuid(),
                'cluster' => 'Adults & Elderly',
                'unit' => 'Adults',
                'name' => 'Infection transmission during screening/sample collection',
                'category' => 'Compliance',
                'description' => 'Because infection transmission may occur during screening, treatment, counseling and sample collection, possibly due to closed rooms and inadequate fan/exhaust layout, transmission between patients and staff can happen.',
                'impact' => 'Closed rooms; inadequate exhaust/ventilation layout',
                'uc_c' => false,
                'status' => 'draft',
                'created_by' => $creatorId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // --- Cluster: Communicable Disease Control ---
            [
                'id' => (string) Str::uuid(),
                'cluster' => 'Communicable Disease Control',
                'unit' => 'Environmental Health',
                'name' => 'Environmental contamination from infectious fluids',
                'category' => 'Compliance',
                'description' => 'Because of contamination of the environment by infectious fluids (vomit, blood, infectious fluids on beds and floors), cross-infection may occur.',
                'impact' => 'Spillage of vomit, blood or infectious fluids on beds and floors',
                'uc_c' => false,
                'status' => 'draft',
                'created_by' => $creatorId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => (string) Str::uuid(),
                'cluster' => 'Communicable Disease Control',
                'unit' => 'Surveillance',
                'name' => 'Technical failure taking peripheral blood samples',
                'category' => 'HR',
                'description' => 'Because of technical failure in taking peripheral blood during screening, possibly due to unskilled staff, this may cause pain and increased risk of infection and transmission.',
                'impact' => 'Unskilled staff; incorrect lancet depth settings',
                'uc_c' => false,
                'status' => 'draft',
                'created_by' => $creatorId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // --- Cluster: Cross Cluster ---
            [
                'id' => (string) Str::uuid(),
                'cluster' => 'Cross Cluster',
                'unit' => 'Laboratory',
                'name' => 'Staff at risk of infection in the laboratory',
                'category' => 'Compliance',
                'description' => 'Because staff may become infected, their work could be disrupted and performance reduced.',
                'impact' => 'Contact with infectious patients or materials',
                'uc_c' => false,
                'status' => 'draft',
                'created_by' => $creatorId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => (string) Str::uuid(),
                'cluster' => 'Cross Cluster',
                'unit' => 'Inpatient',
                'name' => 'Staff injured by sharp table corners',
                'category' => 'HR',
                'description' => 'Because staff clothing may snag on sharp table corners, the sharp edges can cause tears or skin scratches.',
                'impact' => 'Sharp table corners; lack of corner protectors',
                'uc_c' => false,
                'status' => 'draft',
                'created_by' => $creatorId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Insert each risk and attach causes + sub_causes
        foreach ($risks as $idx => $risk) {
            DB::table('risks')->insert($risk);

            // Decide cause category and main cause text per index (some reasonable defaults)
            $causeCategory = 'man';
            $mainCause = '';
            $subCauses = [];

            switch ($risk['cluster']) {
                case 'Management':
                    // for the earlier Management items, derive by unit/name (English)
                    if (stripos($risk['name'], 'Delayed contract') !== false || stripos($risk['name'], 'contract staff') !== false) {
                        $mainCause = 'Tiered payment mechanism and delayed payments';
                        $subCauses = ['Cumbersome payment process', 'Administrative delays'];
                    } elseif (stripos($risk['name'], 'Capitation') !== false) {
                        $mainCause = 'Capitation reduction causing credentialing requirements not met';
                        $subCauses = ['Change in funding mechanism', 'Credentialing standards not achieved'];
                    } elseif (stripos($risk['name'], 'Poor service') !== false || stripos($risk['name'], 'service review') !== false) {
                        $mainCause = 'Suboptimal service quality';
                        $subCauses = ['Lack of staff training', 'Limited resources'];
                    } elseif (stripos($risk['name'], 'Incomplete personnel') !== false || stripos($risk['name'], 'personnel files') !== false) {
                        $mainCause = 'Incomplete or poorly managed personnel files';
                        $subCauses = ['Missing files', 'No formal borrowing procedure'];
                    } else {
                        $mainCause = 'Asset loss due to theft or accidental disposal';
                        $subCauses = ['Insufficient storage security', 'Lack of inventory control'];
                    }
                    break;
                case 'Maternal & Child':
                    $causeCategory = 'man';
                    if (stripos($risk['name'], 'needle') !== false || stripos($risk['name'], 'needle-stick') !== false) {
                        $mainCause = 'Insufficient training on safe injection technique and loss of focus';
                        $subCauses = ['Not using single-handed safe technique', 'Staff fatigue'];
                    } elseif (stripos($risk['name'], 'slip') !== false || stripos($risk['name'], 'slipped') !== false) {
                        $mainCause = 'Unsafe clinical environment (narrow bed, slippery floor)';
                        $subCauses = ['Slippery floor', 'Inadequate-sized equipment'];
                    } elseif (stripos($risk['name'], 'adverse events') !== false || stripos($risk['name'], 'AEFI') !== false) {
                        $mainCause = 'Adverse reaction to vaccine';
                        $subCauses = ['Incomplete allergy history', 'Improper vaccine storage temperature'];
                    } elseif (stripos($risk['name'], 'Incorrect pregnancy') !== false || stripos($risk['name'], 'pregnancy age') !== false) {
                        $mainCause = 'Incomplete patient information (unknown last menstrual period)';
                        $subCauses = ['Patient forgot last menstrual date', 'Insufficient ultrasound checks'];
                    } else {
                        $mainCause = 'Missing immunization history leading to incorrect vaccine administration';
                        $subCauses = ['Immunization record not brought', 'Non-integrated record system'];
                    }
                    break;
                case 'Adults & Elderly':
                    $causeCategory = 'environment';
                    $mainCause = 'Inadequate ventilation and room layout';
                    $subCauses = ['Closed rooms', 'Improper exhaust/fan placement'];
                    break;
                case 'Communicable Disease Control':
                    if (stripos($risk['unit'], 'Environmental') !== false || stripos($risk['unit'], 'Environmental Health') !== false) {
                        $causeCategory = 'environment';
                        $mainCause = 'Contamination from infectious bodily fluids in the environment';
                        $subCauses = ['Vomit or blood spills not cleaned', 'Cleaning procedures not followed'];
                    } else {
                        $causeCategory = 'man';
                        $mainCause = 'Insufficient technical skills for sample collection';
                        $subCauses = ['Undertrained staff', 'Incorrect lancet depth settings'];
                    }
                    break;
                case 'Cross Cluster':
                    if (stripos($risk['unit'], 'Laboratory') !== false) {
                        $causeCategory = 'man';
                        $mainCause = 'Contact with infectious material when working in the laboratory';
                        $subCauses = ['Safety protocols not followed', 'Incomplete personal protective equipment'];
                    } else {
                        $causeCategory = 'man';
                        $mainCause = 'Sharp table corners or inpatient design causing injury';
                        $subCauses = ['Sharp table corners', 'No corner protectors'];
                    }
                    break;
                default:
                    $causeCategory = 'man';
                    $mainCause = 'Human factor / operational issue';
                    $subCauses = ['Operational lapse', 'Training gap'];
                    break;
            }

            $causeId = DB::table('causes')->insertGetId([
                'risk_id' => $risk['id'],
                'category' => $causeCategory,
                'main_cause' => $mainCause,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $insertSub = [];
            foreach ($subCauses as $sc) {
                $insertSub[] = [
                    'cause_id' => $causeId,
                    'sub_cause' => $sc,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            if (!empty($insertSub)) {
                DB::table('sub_causes')->insert($insertSub);
            }
        }
    }
}
