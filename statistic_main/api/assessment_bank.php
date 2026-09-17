<?php
declare(strict_types=1);

return json_decode(<<<'JSON'
{
  "1": {
    "title": "Final Assessment",
    "ask": 20,
    "pass_mark": 80,
    "minutes": 20,
    "intro": "This assessment draws on all modules. Each attempt serves a randomly selected 20 questions from a bank of 60, with a countdown timer. Passing score is 80%.",
    "questions": [
      {
        "module": 4,
        "q": "Which pillar of food security primarily addresses the vulnerability of food systems to shocks such as price spikes and droughts?",
        "options": [
          {
            "text": "Availability",
            "correct": false
          },
          {
            "text": "Access",
            "correct": false
          },
          {
            "text": "Utilization",
            "correct": false
          },
          {
            "text": "Stability",
            "correct": true
          }
        ],
        "explain": "Correct: Stability."
      },
      {
        "module": 4,
        "q": "A high Food Price Volatility Index indicates:",
        "options": [
          {
            "text": "Stable and predictable food prices",
            "correct": false
          },
          {
            "text": "Large fluctuations that reduce household purchasing power",
            "correct": true
          },
          {
            "text": "Declining global commodity prices",
            "correct": false
          },
          {
            "text": "Increased agricultural production",
            "correct": false
          }
        ],
        "explain": "Correct: Large fluctuations that reduce household purchasing power."
      },
      {
        "module": 4,
        "q": "According to WHO classification, childhood anaemia prevalence ≥40% is considered:",
        "options": [
          {
            "text": "Mild public health problem",
            "correct": false
          },
          {
            "text": "Moderate public health problem",
            "correct": false
          },
          {
            "text": "Severe public health problem",
            "correct": true
          },
          {
            "text": "No public health problem",
            "correct": false
          }
        ],
        "explain": "Correct: Severe public health problem."
      },
      {
        "module": 4,
        "q": "Which EAC countries currently have SEVERE childhood anaemia prevalence (≥40%)?",
        "options": [
          {
            "text": "Kenya and Rwanda only",
            "correct": false
          },
          {
            "text": "Burundi and Tanzania only",
            "correct": false
          },
          {
            "text": "DRC, South Sudan, Tanzania, Uganda",
            "correct": true
          },
          {
            "text": "All EAC countries",
            "correct": false
          }
        ],
        "explain": "Correct: DRC, South Sudan, Tanzania, Uganda."
      },
      {
        "module": 4,
        "q": "The most common cause of anaemia globally (approximately 50% of cases) is:",
        "options": [
          {
            "text": "Malaria",
            "correct": false
          },
          {
            "text": "Iron deficiency",
            "correct": true
          },
          {
            "text": "Vitamin A deficiency",
            "correct": false
          },
          {
            "text": "Hookworm infestation only",
            "correct": false
          }
        ],
        "explain": "Correct: Iron deficiency."
      },
      {
        "module": 4,
        "q": "Vitamin A supplementation for children 6–59 months in high-risk areas should be given:",
        "options": [
          {
            "text": "Once per year",
            "correct": false
          },
          {
            "text": "Every 4–6 months",
            "correct": true
          },
          {
            "text": "Daily in low dose",
            "correct": false
          },
          {
            "text": "Only when clinically deficient",
            "correct": false
          }
        ],
        "explain": "Correct: Every 4–6 months."
      },
      {
        "module": 4,
        "q": "Stunting primarily reflects:",
        "options": [
          {
            "text": "Acute/short-term undernutrition",
            "correct": false
          },
          {
            "text": "Chronic or long-term undernutrition",
            "correct": true
          },
          {
            "text": "Overnutrition and obesity",
            "correct": false
          },
          {
            "text": "Micronutrient deficiency only",
            "correct": false
          }
        ],
        "explain": "Correct: Chronic or long-term undernutrition."
      },
      {
        "module": 4,
        "q": "Which country in the EAC has the highest prevalence of stunting (52–56%)?",
        "options": [
          {
            "text": "Kenya",
            "correct": false
          },
          {
            "text": "Burundi",
            "correct": true
          },
          {
            "text": "Rwanda",
            "correct": false
          },
          {
            "text": "Uganda",
            "correct": false
          }
        ],
        "explain": "Correct: Burundi."
      },
      {
        "module": 4,
        "q": "Global Acute Malnutrition (GAM) ≥15% indicates:",
        "options": [
          {
            "text": "Acceptable situation",
            "correct": false
          },
          {
            "text": "Poor situation",
            "correct": false
          },
          {
            "text": "Serious situation",
            "correct": false
          },
          {
            "text": "Critical emergency",
            "correct": true
          }
        ],
        "explain": "Correct: Critical emergency."
      },
      {
        "module": 4,
        "q": "The “triple burden of malnutrition” in the EAC region includes all except:",
        "options": [
          {
            "text": "Undernutrition (stunting, wasting)",
            "correct": false
          },
          {
            "text": "Micronutrient deficiencies",
            "correct": false
          },
          {
            "text": "Overweight/obesity",
            "correct": false
          },
          {
            "text": "Excessive physical activity",
            "correct": true
          }
        ],
        "explain": "Correct: Excessive physical activity."
      },
      {
        "module": 4,
        "q": "Low birth weight is defined as birth weight less than:",
        "options": [
          {
            "text": "2,000 g",
            "correct": false
          },
          {
            "text": "2,500 g",
            "correct": true
          },
          {
            "text": "3,000 g",
            "correct": false
          },
          {
            "text": "3,500 g",
            "correct": false
          }
        ],
        "explain": "Correct: 2,500 g."
      },
      {
        "module": 4,
        "q": "The recommended software for analysing anthropometric data in children under 5 is:",
        "options": [
          {
            "text": "Microsoft Excel only",
            "correct": false
          },
          {
            "text": "WHO Anthro and/or ENA for SMART",
            "correct": true
          },
          {
            "text": "SPSS only",
            "correct": false
          },
          {
            "text": "Manual calculation",
            "correct": false
          }
        ],
        "explain": "Correct: WHO Anthro and/or ENA for SMART."
      },
      {
        "module": 4,
        "q": "When stunting prevalence exceeds 40%, the appropriate response level is:",
        "options": [
          {
            "text": "Routine programming",
            "correct": false
          },
          {
            "text": "District-level interventions",
            "correct": false
          },
          {
            "text": "National emergency priority with multi-sectoral action",
            "correct": true
          },
          {
            "text": "No action required",
            "correct": false
          }
        ],
        "explain": "Correct: National emergency priority with multi-sectoral action."
      },
      {
        "module": 4,
        "q": "The first 1,000 days (from conception to 2 years) is the critical window for preventing:",
        "options": [
          {
            "text": "Adolescent overweight",
            "correct": false
          },
          {
            "text": "Irreversible stunting",
            "correct": true
          },
          {
            "text": "Acute malnutrition only",
            "correct": false
          },
          {
            "text": "Vitamin A deficiency",
            "correct": false
          }
        ],
        "explain": "Correct: Irreversible stunting."
      },
      {
        "module": 4,
        "q": "Which intervention is proven to reduce vitamin A deficiency and child mortality by up to 23%?",
        "options": [
          {
            "text": "Deworming only",
            "correct": false
          },
          {
            "text": "High-dose vitamin A supplementation every 6 months",
            "correct": true
          },
          {
            "text": "Iron supplementation",
            "correct": false
          },
          {
            "text": "Zinc supplementation",
            "correct": false
          }
        ],
        "explain": "Correct: High-dose vitamin A supplementation every 6 months."
      },
      {
        "module": 4,
        "q": "The WHO global target for anaemia in women of reproductive age by 2030 is a ___ reduction from 2019 levels.",
        "options": [
          {
            "text": "30%",
            "correct": false
          },
          {
            "text": "50%",
            "correct": true
          },
          {
            "text": "75%",
            "correct": false
          },
          {
            "text": "100%",
            "correct": false
          }
        ],
        "explain": "Correct: 50%."
      },
      {
        "module": 4,
        "q": "Which of the following is NOT a recommended quality assurance measure in nutrition surveys?",
        "options": [
          {
            "text": "5–10% duplicate measurements",
            "correct": false
          },
          {
            "text": "Standardized training and pilot testing",
            "correct": false
          },
          {
            "text": "Using WHO growth standards",
            "correct": false
          },
          {
            "text": "Skipping plausibility checks to save time",
            "correct": true
          }
        ],
        "explain": "Correct: Skipping plausibility checks to save time."
      },
      {
        "module": 4,
        "q": "Prevalence of wasting reflects:",
        "options": [
          {
            "text": "Long-term cumulative deficits",
            "correct": false
          },
          {
            "text": "Recent acute malnutrition",
            "correct": true
          },
          {
            "text": "Micronutrient status",
            "correct": false
          },
          {
            "text": "Birth outcomes only",
            "correct": false
          }
        ],
        "explain": "Correct: Recent acute malnutrition."
      },
      {
        "module": 4,
        "q": "The “hidden hunger” phenomenon in the EAC is primarily driven by:",
        "options": [
          {
            "text": "Excess calories from diverse diets",
            "correct": false
          },
          {
            "text": "Deficiencies of vitamins and minerals despite adequate energy intake",
            "correct": true
          },
          {
            "text": "Overconsumption of animal-source foods",
            "correct": false
          },
          {
            "text": "Seasonal food surpluses",
            "correct": false
          }
        ],
        "explain": "Correct: Deficiencies of vitamins and minerals despite adequate energy intake."
      },
      {
        "module": 4,
        "q": "Which is the most cost-effective intervention for preventing vitamin A deficiency in the EAC context?",
        "options": [
          {
            "text": "Food fortification of oil and sugar",
            "correct": false
          },
          {
            "text": "High-dose supplementation twice yearly",
            "correct": false
          },
          {
            "text": "Biofortified crops (e.g., orange-fleshed sweet potato)",
            "correct": false
          },
          {
            "text": "All of the above are highly cost-effective",
            "correct": true
          }
        ],
        "explain": "Correct: All of the above are highly cost-effective."
      },
      {
        "module": 4,
        "q": "In programmatic response matrices, when childhood anaemia is classified as “Severe”, the response should include:",
        "options": [
          {
            "text": "Routine supplementation only",
            "correct": false
          },
          {
            "text": "Blanket iron-folic acid supplementation + fortification + malaria control",
            "correct": true
          },
          {
            "text": "Dietary education only",
            "correct": false
          },
          {
            "text": "Monitoring every 5 years",
            "correct": false
          }
        ],
        "explain": "Correct: Blanket iron-folic acid supplementation + fortification + malaria control."
      },
      {
        "module": 4,
        "q": "Adolescent overweight in the EAC is an emerging component of:",
        "options": [
          {
            "text": "The double burden only",
            "correct": false
          },
          {
            "text": "The triple burden of malnutrition",
            "correct": true
          },
          {
            "text": "Acute food insecurity",
            "correct": false
          },
          {
            "text": "Seasonal hunger",
            "correct": false
          }
        ],
        "explain": "Correct: The triple burden of malnutrition."
      },
      {
        "module": 4,
        "q": "The preferred timing for nutrition surveys in most EAC countries to capture the hunger season is:",
        "options": [
          {
            "text": "Immediately after harvest",
            "correct": false
          },
          {
            "text": "During or just before the lean/hunger season (often Feb–May)",
            "correct": true
          },
          {
            "text": "During the rainy season only",
            "correct": false
          },
          {
            "text": "Timing does not matter",
            "correct": false
          }
        ],
        "explain": "Correct: During or just before the lean/hunger season (often Feb–May)."
      },
      {
        "module": 4,
        "q": "Which indicator is most sensitive to recent shocks and is used in emergency contexts?",
        "options": [
          {
            "text": "Stunting",
            "correct": false
          },
          {
            "text": "Underweight",
            "correct": false
          },
          {
            "text": "Wasting (Weight-for-Height)",
            "correct": true
          },
          {
            "text": "Height-for-Age",
            "correct": false
          }
        ],
        "explain": "Correct: Wasting (Weight-for-Height)."
      },
      {
        "module": 4,
        "q": "Successful scale-up of anticipatory action and nutrition-sensitive programming in the EAC requires strong:",
        "options": [
          {
            "text": "Regional frameworks and coordination (e.g., SADC, EAC strategies)",
            "correct": true
          },
          {
            "text": "National policies only",
            "correct": false
          },
          {
            "text": "Donor funding without coordination",
            "correct": false
          },
          {
            "text": "Individual household actions only",
            "correct": false
          }
        ],
        "explain": "Correct: Regional frameworks and coordination (e.g., SADC, EAC strategies)."
      },
      {
        "module": 4,
        "q": "Question 1: Stunting is defined as:",
        "options": [
          {
            "text": "Weight-for-height < -2 SD",
            "correct": false
          },
          {
            "text": "Height-for-age < -2 SD",
            "correct": true
          },
          {
            "text": "Weight-for-age < -2 SD",
            "correct": false
          },
          {
            "text": "BMI-for-age < -2 SD",
            "correct": false
          }
        ],
        "explain": "Correct: Height-for-age < -2 SD."
      },
      {
        "module": 4,
        "q": "Question 2: What is the critical intervention window for preventing stunting?",
        "options": [
          {
            "text": "Birth to 6 months",
            "correct": false
          },
          {
            "text": "Pregnancy to 24 months (the first 1,000 days)",
            "correct": true
          },
          {
            "text": "0-5 years",
            "correct": false
          },
          {
            "text": "Adolescence",
            "correct": false
          }
        ],
        "explain": "Correct: Pregnancy to 24 months (the first 1,000 days)."
      },
      {
        "module": 4,
        "q": "Question 3: A wasting prevalence of 12% in children under 5 indicates a:",
        "options": [
          {
            "text": "Acceptable situation",
            "correct": false
          },
          {
            "text": "Poor situation",
            "correct": false
          },
          {
            "text": "Serious situation requiring humanitarian response",
            "correct": true
          },
          {
            "text": "Critical emergency",
            "correct": false
          }
        ],
        "explain": "Correct: Serious situation requiring humanitarian response."
      },
      {
        "module": 4,
        "q": "Question 4: Which indicator reflects ACUTE malnutrition?",
        "options": [
          {
            "text": "Stunting",
            "correct": false
          },
          {
            "text": "Wasting",
            "correct": true
          },
          {
            "text": "Anemia",
            "correct": false
          },
          {
            "text": "Low birth weight",
            "correct": false
          }
        ],
        "explain": "Correct: Wasting."
      },
      {
        "module": 4,
        "q": "Question 5: What is the mortality risk multiplier for children with severe wasting?",
        "options": [
          {
            "text": "3 times higher",
            "correct": false
          },
          {
            "text": "5 times higher",
            "correct": false
          },
          {
            "text": "9 times higher",
            "correct": true
          },
          {
            "text": "15 times higher",
            "correct": false
          }
        ],
        "explain": "Correct: 9 times higher."
      },
      {
        "module": 4,
        "q": "Question 6: Which assessment type should be conducted annually or in emergencies to measure wasting?",
        "options": [
          {
            "text": "DHS (Demographic and Health Survey)",
            "correct": false
          },
          {
            "text": "SMART Survey",
            "correct": true
          },
          {
            "text": "MICS",
            "correct": false
          },
          {
            "text": "Food Balance Sheet",
            "correct": false
          }
        ],
        "explain": "Correct: SMART Survey."
      },
      {
        "module": 4,
        "q": "Question 7: When should lean season nutritional assessments typically be conducted?",
        "options": [
          {
            "text": "September-November (post-harvest)",
            "correct": false
          },
          {
            "text": "February-April (pre-harvest)",
            "correct": true
          },
          {
            "text": "December-January (during harvest)",
            "correct": false
          },
          {
            "text": "Any time of year",
            "correct": false
          }
        ],
        "explain": "Correct: February-April (pre-harvest)."
      },
      {
        "module": 4,
        "q": "Question 8: What is the recommended frequency for equipment calibration during nutrition surveys?",
        "options": [
          {
            "text": "Weekly",
            "correct": false
          },
          {
            "text": "Daily",
            "correct": true
          },
          {
            "text": "Before each measurement",
            "correct": false
          },
          {
            "text": "Monthly",
            "correct": false
          }
        ],
        "explain": "Correct: Daily."
      },
      {
        "module": 4,
        "q": "Question 9: When wasting prevalence ≥ 15%, what response is required?",
        "options": [
          {
            "text": "Routine health facility services only",
            "correct": false
          },
          {
            "text": "Targeted supplementary feeding programs",
            "correct": false
          },
          {
            "text": "Critical emergency humanitarian response (mass screening, CMAM scale-up, blanket feeding)",
            "correct": true
          },
          {
            "text": "No intervention needed",
            "correct": false
          }
        ],
        "explain": "Correct: Critical emergency humanitarian response (mass screening, CMAM scale-up, blanket feeding)."
      },
      {
        "module": 4,
        "q": "Question 10: How often should impact indicators (like stunting prevalence) be measured?",
        "options": [
          {
            "text": "Monthly",
            "correct": false
          },
          {
            "text": "Quarterly",
            "correct": false
          },
          {
            "text": "Annually",
            "correct": false
          },
          {
            "text": "Every 2-5 years (major surveys)",
            "correct": true
          }
        ],
        "explain": "Correct: Every 2-5 years (major surveys)."
      },
      {
        "module": 4,
        "q": "Question 1: Which EAC country has the highest stunting prevalence?",
        "options": [
          {
            "text": "Kenya",
            "correct": false
          },
          {
            "text": "Burundi (52-56%)",
            "correct": true
          },
          {
            "text": "Tanzania",
            "correct": false
          },
          {
            "text": "Rwanda",
            "correct": false
          }
        ],
        "explain": "Correct: Burundi (52-56%)."
      },
      {
        "module": 4,
        "q": "Question 2: A Coefficient of Variation (CV) greater than 30% for food prices indicates:",
        "options": [
          {
            "text": "Low volatility",
            "correct": false
          },
          {
            "text": "Moderate volatility",
            "correct": false
          },
          {
            "text": "High volatility - significant market dysfunction",
            "correct": true
          },
          {
            "text": "No volatility",
            "correct": false
          }
        ],
        "explain": "Correct: High volatility - significant market dysfunction."
      },
      {
        "module": 4,
        "q": "Question 3: Four EAC countries have severe public health problems with childhood anemia. Which countries are they?",
        "options": [
          {
            "text": "Kenya, Rwanda, Burundi, Uganda",
            "correct": false
          },
          {
            "text": "DRC, South Sudan, Tanzania, Uganda",
            "correct": true
          },
          {
            "text": "All seven countries",
            "correct": false
          },
          {
            "text": "Only DRC and South Sudan",
            "correct": false
          }
        ],
        "explain": "Correct: DRC, South Sudan, Tanzania, Uganda."
      },
      {
        "module": 4,
        "q": "Question 4: What is the hemoglobin cutoff for anemia in children aged 6-59 months?",
        "options": [
          {
            "text": "< 10.0 g/dL",
            "correct": false
          },
          {
            "text": "< 11.0 g/dL",
            "correct": true
          },
          {
            "text": "< 12.0 g/dL",
            "correct": false
          },
          {
            "text": "< 13.0 g/dL",
            "correct": false
          }
        ],
        "explain": "Correct: < 11.0 g/dL."
      },
      {
        "module": 4,
        "q": "Question 5: The WHO global target for low birth weight is:",
        "options": [
          {
            "text": "Complete elimination by 2025",
            "correct": false
          },
          {
            "text": "30% reduction by 2025",
            "correct": true
          },
          {
            "text": "50% reduction by 2030",
            "correct": false
          },
          {
            "text": "No specific target exists",
            "correct": false
          }
        ],
        "explain": "Correct: 30% reduction by 2025."
      },
      {
        "module": 4,
        "q": "Question 6: Vitamin A supplementation for children 6-59 months should be provided:",
        "options": [
          {
            "text": "Monthly",
            "correct": false
          },
          {
            "text": "Every 3 months",
            "correct": false
          },
          {
            "text": "Every 6 months",
            "correct": true
          },
          {
            "text": "Annually",
            "correct": false
          }
        ],
        "explain": "Correct: Every 6 months."
      },
      {
        "module": 4,
        "q": "Question 7: The custodian agency for the Food Price Index is:",
        "options": [
          {
            "text": "World Bank",
            "correct": false
          },
          {
            "text": "FAO",
            "correct": true
          },
          {
            "text": "WHO",
            "correct": false
          },
          {
            "text": "UNICEF",
            "correct": false
          }
        ],
        "explain": "Correct: FAO."
      },
      {
        "module": 4,
        "q": "Question 8: Ready-to-Use Therapeutic Foods (RUTF) are used to treat:",
        "options": [
          {
            "text": "Stunting",
            "correct": false
          },
          {
            "text": "Severe acute malnutrition without medical complications",
            "correct": true
          },
          {
            "text": "Anemia",
            "correct": false
          },
          {
            "text": "Vitamin A deficiency",
            "correct": false
          }
        ],
        "explain": "Correct: Severe acute malnutrition without medical complications."
      },
      {
        "module": 4,
        "q": "Question 9: SMART surveys typically take how long to complete?",
        "options": [
          {
            "text": "6-8 months",
            "correct": false
          },
          {
            "text": "3-4 months",
            "correct": false
          },
          {
            "text": "2-3 weeks",
            "correct": true
          },
          {
            "text": "1 year",
            "correct": false
          }
        ],
        "explain": "Correct: 2-3 weeks."
      },
      {
        "module": 4,
        "q": "Question 10: Which of the following is a cause of INTRAUTERINE growth restriction leading to low birth weight?",
        "options": [
          {
            "text": "Maternal anemia and undernutrition",
            "correct": true
          },
          {
            "text": "Excessive weight gain during pregnancy",
            "correct": false
          },
          {
            "text": "High maternal education",
            "correct": false
          },
          {
            "text": "Urban residence",
            "correct": false
          }
        ],
        "explain": "Correct: Maternal anemia and undernutrition."
      },
      {
        "module": 4,
        "q": "Question 11: The \"double burden of malnutrition\" in the EAC refers to:",
        "options": [
          {
            "text": "Stunting and wasting occurring together",
            "correct": false
          },
          {
            "text": "Undernutrition and overweight/obesity coexisting in the same population",
            "correct": true
          },
          {
            "text": "Anemia and vitamin A deficiency",
            "correct": false
          },
          {
            "text": "Food insecurity and poverty",
            "correct": false
          }
        ],
        "explain": "Correct: Undernutrition and overweight/obesity coexisting in the same population."
      },
      {
        "module": 4,
        "q": "Question 12: What percentage of duplicate measurements is recommended during anthropometric surveys?",
        "options": [
          {
            "text": "1-2%",
            "correct": false
          },
          {
            "text": "5-10%",
            "correct": true
          },
          {
            "text": "20-25%",
            "correct": false
          },
          {
            "text": "50%",
            "correct": false
          }
        ],
        "explain": "Correct: 5-10%."
      },
      {
        "module": 4,
        "q": "Question 13: When stunting prevalence is > 40%, what level of response is required?",
        "options": [
          {
            "text": "Community-level interventions only",
            "correct": false
          },
          {
            "text": "District-level programming",
            "correct": false
          },
          {
            "text": "National emergency priority with multi-sectoral approach",
            "correct": true
          },
          {
            "text": "No intervention needed",
            "correct": false
          }
        ],
        "explain": "Correct: National emergency priority with multi-sectoral approach."
      },
      {
        "module": 4,
        "q": "Question 14: Which software is recommended for analyzing anthropometric data for children under 5?",
        "options": [
          {
            "text": "Microsoft Excel only",
            "correct": false
          },
          {
            "text": "WHO Anthro and/or ENA for SMART",
            "correct": true
          },
          {
            "text": "Any statistical software",
            "correct": false
          },
          {
            "text": "Manual calculations only",
            "correct": false
          }
        ],
        "explain": "Correct: WHO Anthro and/or ENA for SMART."
      },
      {
        "module": 4,
        "q": "Question 15: The primary cause of anemia worldwide is:",
        "options": [
          {
            "text": "Vitamin A deficiency",
            "correct": false
          },
          {
            "text": "Iron deficiency (accounts for ~50% of cases)",
            "correct": true
          },
          {
            "text": "Malaria",
            "correct": false
          },
          {
            "text": "Genetic disorders",
            "correct": false
          }
        ],
        "explain": "Correct: Iron deficiency (accounts for ~50% of cases)."
      },
      {
        "module": 5,
        "q": "What was the primary problem with regional FNS reporting before the EAC Framework was implemented?",
        "options": [
          {
            "text": "Lack of funding for surveys",
            "correct": false
          },
          {
            "text": "Incompatible methodologies and indicators preventing valid regional aggregation",
            "correct": true
          },
          {
            "text": "Insufficient technical capacity in Partner States",
            "correct": false
          },
          {
            "text": "Political resistance to data sharing",
            "correct": false
          }
        ],
        "explain": "Correct: Incompatible methodologies and indicators preventing valid regional aggregation."
      },
      {
        "module": 5,
        "q": "The five-tier institutional architecture includes all of the following EXCEPT:",
        "options": [
          {
            "text": "Household & Community Level",
            "correct": false
          },
          {
            "text": "District Level",
            "correct": false
          },
          {
            "text": "Provincial Coordination Level",
            "correct": true
          },
          {
            "text": "National Level",
            "correct": false
          }
        ],
        "explain": "Correct: Provincial Coordination Level."
      },
      {
        "module": 5,
        "q": "What is the primary function of the National Steering Committee?",
        "options": [
          {
            "text": "Conduct technical data analysis",
            "correct": false
          },
          {
            "text": "Collect household-level data",
            "correct": false
          },
          {
            "text": "Develop survey questionnaires",
            "correct": false
          },
          {
            "text": "Approve workplans, validate reports, provide policy guidance, and mobilize resources",
            "correct": true
          }
        ],
        "explain": "Correct: Approve workplans, validate reports, provide policy guidance, and mobilize resources."
      },
      {
        "module": 5,
        "q": "According to the Framework, how many staff should the EAC Regional FNS Monitoring Desk have?",
        "options": [
          {
            "text": "1 coordinator only",
            "correct": false
          },
          {
            "text": "4 dedicated staff (coordinator, statistics/M&E officer, data analyst/GIS specialist, admin support)",
            "correct": true
          },
          {
            "text": "10-12 staff covering all technical areas",
            "correct": false
          },
          {
            "text": "Staff shared with other EAC departments",
            "correct": false
          }
        ],
        "explain": "Correct: 4 dedicated staff (coordinator, statistics/M&E officer, data analyst/GIS specialist, admin support)."
      },
      {
        "module": 5,
        "q": "Harmonization of FNS monitoring occurs across three dimensions. Which of the following is NOT one of these dimensions?",
        "options": [
          {
            "text": "WHAT to measure (indicator definitions)",
            "correct": false
          },
          {
            "text": "HOW to measure (methodologies and tools)",
            "correct": false
          },
          {
            "text": "WHERE to measure (geographic targeting)",
            "correct": true
          },
          {
            "text": "WHEN to measure (timing and reporting schedules)",
            "correct": false
          }
        ],
        "explain": "Correct: WHERE to measure (geographic targeting)."
      },
      {
        "module": 5,
        "q": "For measuring stunting (Indicator 17), which reference standard must ALL Partner States use?",
        "options": [
          {
            "text": "WHO Child Growth Standards 2006",
            "correct": true
          },
          {
            "text": "NCHS 1977 reference",
            "correct": false
          },
          {
            "text": "National growth references (each country uses own)",
            "correct": false
          },
          {
            "text": "Any internationally recognized standard",
            "correct": false
          }
        ],
        "explain": "Correct: WHO Child Growth Standards 2006."
      },
      {
        "module": 5,
        "q": "What is the standardized main assessment window for conducting DHS and National Nutrition Surveys across the EAC?",
        "options": [
          {
            "text": "January-March (lean season)",
            "correct": false
          },
          {
            "text": "April-June (pre-harvest)",
            "correct": false
          },
          {
            "text": "July-September (post-harvest)",
            "correct": true
          },
          {
            "text": "Any time of year (no standardization needed)",
            "correct": false
          }
        ],
        "explain": "Correct: July-September (post-harvest)."
      },
      {
        "module": 5,
        "q": "What is the deadline for Partner States to submit their annual FNS data to the EAC Secretariat?",
        "options": [
          {
            "text": "December 31 of the survey year",
            "correct": false
          },
          {
            "text": "January 31 of the following year",
            "correct": false
          },
          {
            "text": "February 28 of the following year",
            "correct": false
          },
          {
            "text": "March 31 of the following year",
            "correct": true
          }
        ],
        "explain": "Correct: March 31 of the following year."
      },
      {
        "module": 5,
        "q": "Before an anthropometric survey, enumerators must pass a standardization test. What is the WHO criterion for height measurement precision?",
        "options": [
          {
            "text": "Technical Error of Measurement (TEM) < 5mm",
            "correct": false
          },
          {
            "text": "Technical Error of Measurement (TEM) < 7mm",
            "correct": true
          },
          {
            "text": "Technical Error of Measurement (TEM) < 10mm",
            "correct": false
          },
          {
            "text": "No standardization test required if enumerators are trained",
            "correct": false
          }
        ],
        "explain": "Correct: Technical Error of Measurement (TEM) < 7mm."
      },
      {
        "module": 5,
        "q": "What happens if a country's survey data does not meet the minimum \"GOOD\" data quality score?",
        "options": [
          {
            "text": "Data is automatically accepted anyway",
            "correct": false
          },
          {
            "text": "Country receives a warning but data is included",
            "correct": false
          },
          {
            "text": "Investigation triggered and data potentially excluded from regional reporting until issues resolved",
            "correct": true
          },
          {
            "text": "Data quality criteria are optional guidelines only",
            "correct": false
          }
        ],
        "explain": "Correct: Investigation triggered and data potentially excluded from regional reporting until issues resolved."
      }
    ]
  },
  "4": {
    "pass_mark": 75,
    "ask": 20,
    "title": "Final Assessment",
    "intro": "This assessment has 30 questions in its bank; you will be asked a randomly selected 20. The question order and the answer options are shuffled on every attempt, so refreshing or retaking the assessment mixes in new questions. You need 75% to pass and earn your certificate.",
    "questions": [
      {
        "q": "What is Public Sector Debt Statistics (PSDS)?",
        "options": [
          {
            "text": "A framework used for measuring and reporting public debt data",
            "correct": true
          },
          {
            "text": "A register of private company profits",
            "correct": false
          },
          {
            "text": "A schedule of central bank policy rates",
            "correct": false
          },
          {
            "text": "A national population census",
            "correct": false
          }
        ],
        "explain": "PSDS is a framework for measuring and reporting public debt data; it records total gross public debt."
      },
      {
        "q": "A debt instrument is:",
        "options": [
          {
            "text": "A financial claim requiring future payment of interest and/or principal by the debtor to the creditor",
            "correct": true
          },
          {
            "text": "A grant that never has to be repaid",
            "correct": false
          },
          {
            "text": "Any government building or piece of land",
            "correct": false
          },
          {
            "text": "A tax on imported goods",
            "correct": false
          }
        ],
        "explain": "A debt instrument is a financial claim requiring payment(s) of interest and/or principal at a future date or dates."
      },
      {
        "q": "Total gross public debt consists of:",
        "options": [
          {
            "text": "All government liabilities that are debt instruments",
            "correct": true
          },
          {
            "text": "Only foreign loans",
            "correct": false
          },
          {
            "text": "Only treasury bills",
            "correct": false
          },
          {
            "text": "Government land and equipment",
            "correct": false
          }
        ],
        "explain": "Gross public debt is all government liabilities that are debt instruments."
      },
      {
        "q": "PSDS statistics are used for:",
        "options": [
          {
            "text": "Analysing fiscal sustainability and measuring the government's risk exposure",
            "correct": true
          },
          {
            "text": "Setting commercial bank lending rates",
            "correct": false
          },
          {
            "text": "Auditing private firms",
            "correct": false
          },
          {
            "text": "Forecasting the weather",
            "correct": false
          }
        ],
        "explain": "PSDS supports analysis of fiscal sustainability and measurement of the government's risk exposure."
      },
      {
        "q": "Which standard guides the compilation of PSDS?",
        "options": [
          {
            "text": "The Public Sector Debt Statistics Guide (PSDSG) 2013",
            "correct": true
          },
          {
            "text": "The Balance of Payments Manual (BPM6)",
            "correct": false
          },
          {
            "text": "Basel III",
            "correct": false
          },
          {
            "text": "The COFOG classification",
            "correct": false
          }
        ],
        "explain": "Compilation is guided by the PSDSG 2013 for consistency and comparability between countries."
      },
      {
        "q": "Which institutional units are included in PSDS compilation?",
        "options": [
          {
            "text": "General government and public corporations",
            "correct": true
          },
          {
            "text": "Only the central bank",
            "correct": false
          },
          {
            "text": "Private households and firms",
            "correct": false
          },
          {
            "text": "Foreign governments only",
            "correct": false
          }
        ],
        "explain": "PSDS includes debt from general government (central, state, local) and public corporations (nonfinancial and financial)."
      },
      {
        "q": "Central government in PSDS comprises:",
        "options": [
          {
            "text": "Budgetary central government and extra-budgetary units",
            "correct": true
          },
          {
            "text": "Only the central bank",
            "correct": false
          },
          {
            "text": "Local councils only",
            "correct": false
          },
          {
            "text": "Private contractors",
            "correct": false
          }
        ],
        "explain": "Central government covers budgetary central government and extra-budgetary units."
      },
      {
        "q": "Under debt securities, PSDS records:",
        "options": [
          {
            "text": "Treasury bonds and Treasury bills",
            "correct": true
          },
          {
            "text": "Land and buildings",
            "correct": false
          },
          {
            "text": "Tax revenue",
            "correct": false
          },
          {
            "text": "Employee salaries",
            "correct": false
          }
        ],
        "explain": "Debt securities comprise treasury bonds and treasury bills."
      },
      {
        "q": "Special Drawing Rights (SDRs) in PSDS refer to:",
        "options": [
          {
            "text": "IMF allocations to countries",
            "correct": true
          },
          {
            "text": "Local municipal bonds",
            "correct": false
          },
          {
            "text": "Private bank deposits",
            "correct": false
          },
          {
            "text": "Export earnings",
            "correct": false
          }
        ],
        "explain": "SDRs are IMF allocations to countries, recorded as a debt instrument."
      },
      {
        "q": "How are government guarantees treated in PSDS?",
        "options": [
          {
            "text": "Published as memorandum items",
            "correct": true
          },
          {
            "text": "Recorded as revenue",
            "correct": false
          },
          {
            "text": "Ignored entirely",
            "correct": false
          },
          {
            "text": "Counted as non-financial assets",
            "correct": false
          }
        ],
        "explain": "Government guarantees are published as memorandum items."
      },
      {
        "q": "Where is PSDS data found?",
        "options": [
          {
            "text": "Partner States' Ministries of Finance, Central Banks and NSOs websites, and the EAC Statistics Portal",
            "correct": true
          },
          {
            "text": "Only in printed newspapers",
            "correct": false
          },
          {
            "text": "On private company blogs",
            "correct": false
          },
          {
            "text": "Only via commercial banks",
            "correct": false
          }
        ],
        "explain": "Data is found on the Partner States' Ministries of Finance, Central Banks and NSOs websites, and on the EAC Statistics Portal."
      },
      {
        "q": "By residence of holder, domestic debt is:",
        "options": [
          {
            "text": "Held by resident units",
            "correct": true
          },
          {
            "text": "Held by non-resident units",
            "correct": false
          },
          {
            "text": "Always in foreign currency",
            "correct": false
          },
          {
            "text": "Always short-term",
            "correct": false
          }
        ],
        "explain": "Domestic debt is held by resident units; external debt is held by non-resident units."
      },
      {
        "q": "Under classification by maturity, long-term debt has a maturity of:",
        "options": [
          {
            "text": "More than one year",
            "correct": true
          },
          {
            "text": "One year or less",
            "correct": false
          },
          {
            "text": "Exactly six months",
            "correct": false
          },
          {
            "text": "Less than one month",
            "correct": false
          }
        ],
        "explain": "Long-term debt matures in more than one year; short-term in one year or less."
      },
      {
        "q": "By instrument type, marketable securities include:",
        "options": [
          {
            "text": "Bonds and treasury bills",
            "correct": true
          },
          {
            "text": "Loans and arrears",
            "correct": false
          },
          {
            "text": "Land and buildings",
            "correct": false
          },
          {
            "text": "Tax receipts",
            "correct": false
          }
        ],
        "explain": "Marketable securities are bonds and treasury bills; non-marketable debt includes loans and arrears."
      },
      {
        "q": "General Government Debt (GGD) is the debt of:",
        "options": [
          {
            "text": "Central, state and local governments",
            "correct": true
          },
          {
            "text": "Public corporations only",
            "correct": false
          },
          {
            "text": "Private banks",
            "correct": false
          },
          {
            "text": "Foreign governments",
            "correct": false
          }
        ],
        "explain": "GGD is the debt of central, state and local governments."
      },
      {
        "q": "Public Sector Debt (PSD) equals:",
        "options": [
          {
            "text": "GGD plus the debt of public financial and non-financial corporations",
            "correct": true
          },
          {
            "text": "GGD minus grants",
            "correct": false
          },
          {
            "text": "Only external debt",
            "correct": false
          },
          {
            "text": "Only short-term debt",
            "correct": false
          }
        ],
        "explain": "PSD = GGD plus the debt of public financial and non-financial corporations."
      },
      {
        "q": "Why is the debt of public corporations included in PSDS?",
        "options": [
          {
            "text": "Guaranteed borrowing raises fiscal risk, so a fuller picture of exposure is needed",
            "correct": true
          },
          {
            "text": "To make the debt total look smaller",
            "correct": false
          },
          {
            "text": "Because it is required for the census",
            "correct": false
          },
          {
            "text": "To set commercial interest rates",
            "correct": false
          }
        ],
        "explain": "Public corporations can borrow heavily under guarantees; including their debt shows the government's full fiscal exposure."
      },
      {
        "q": "External debt is debt owed to:",
        "options": [
          {
            "text": "Non-residents (foreign governments, international organisations, foreign banks, bondholders)",
            "correct": true
          },
          {
            "text": "Residents only",
            "correct": false
          },
          {
            "text": "The central bank only",
            "correct": false
          },
          {
            "text": "Local households only",
            "correct": false
          }
        ],
        "explain": "External debt is owed to non-residents; domestic debt is owed to residents."
      },
      {
        "q": "Gross debt consists of:",
        "options": [
          {
            "text": "All liabilities that are debt instruments",
            "correct": true
          },
          {
            "text": "Only foreign-currency loans",
            "correct": false
          },
          {
            "text": "Only short-term debt",
            "correct": false
          },
          {
            "text": "Government buildings and land",
            "correct": false
          }
        ],
        "explain": "Gross debt is the total of all liabilities that are debt instruments."
      },
      {
        "q": "Net debt is calculated as:",
        "options": [
          {
            "text": "Gross debt minus financial assets in corresponding debt instruments",
            "correct": true
          },
          {
            "text": "Gross debt plus interest payments",
            "correct": false
          },
          {
            "text": "Total revenue minus total expenditure",
            "correct": false
          },
          {
            "text": "Gross debt times the interest rate",
            "correct": false
          }
        ],
        "explain": "Net debt is gross debt minus financial assets corresponding to debt instruments."
      },
      {
        "q": "The debt-to-GDP ratio is calculated as:",
        "options": [
          {
            "text": "(Total Public Debt ÷ GDP) × 100",
            "correct": true
          },
          {
            "text": "(GDP ÷ Total Public Debt) × 100",
            "correct": false
          },
          {
            "text": "Total Public Debt − GDP",
            "correct": false
          },
          {
            "text": "GDP × the interest rate",
            "correct": false
          }
        ],
        "explain": "Debt-to-GDP = (Total Public Debt ÷ GDP) × 100."
      },
      {
        "q": "In terms of the debt-to-GDP ratio, a lower ratio is generally:",
        "options": [
          {
            "text": "More sustainable",
            "correct": true
          },
          {
            "text": "Less sustainable",
            "correct": false
          },
          {
            "text": "Always a sign of crisis",
            "correct": false
          },
          {
            "text": "Irrelevant to sustainability",
            "correct": false
          }
        ],
        "explain": "A lower debt-to-GDP ratio is generally considered more sustainable."
      },
      {
        "q": "The EAMU convergence ceiling for public debt is:",
        "options": [
          {
            "text": "50 percent of GDP in net present value terms",
            "correct": true
          },
          {
            "text": "3 percent of GDP",
            "correct": false
          },
          {
            "text": "6 percent of GDP",
            "correct": false
          },
          {
            "text": "100 percent of GDP",
            "correct": false
          }
        ],
        "explain": "The EAMU ceiling is public debt in NPV of 50 percent of GDP."
      },
      {
        "q": "Contingent liabilities are:",
        "options": [
          {
            "text": "Obligations that arise only if a particular future event occurs",
            "correct": true
          },
          {
            "text": "Debts that must always be repaid on a fixed date",
            "correct": false
          },
          {
            "text": "Grants that are never repaid",
            "correct": false
          },
          {
            "text": "Government-owned land and buildings",
            "correct": false
          }
        ],
        "explain": "Contingent liabilities arise only if a particular, discrete future event occurs — e.g. guarantees, lawsuits or PPP commitments."
      },
      {
        "q": "Why do contingent liabilities matter?",
        "options": [
          {
            "text": "They can affect fiscal sustainability even if not recorded as direct liabilities",
            "correct": true
          },
          {
            "text": "They reduce the need to publish debt data",
            "correct": false
          },
          {
            "text": "They always lower the debt-to-GDP ratio",
            "correct": false
          },
          {
            "text": "They replace the need for a budget",
            "correct": false
          }
        ],
        "explain": "They matter because they can affect fiscal sustainability even when not recorded as direct liabilities."
      },
      {
        "q": "An explicit contingent liability is:",
        "options": [
          {
            "text": "A contractual arrangement giving rise to conditional payment requirements",
            "correct": true
          },
          {
            "text": "A liability recognised only after the event, with no contract",
            "correct": false
          },
          {
            "text": "A grant received from abroad",
            "correct": false
          },
          {
            "text": "A short-term treasury bill",
            "correct": false
          }
        ],
        "explain": "Explicit contingent liabilities are contractual; implicit ones arise without a legal or contractual source and are recognised after the event."
      },
      {
        "q": "Which indicator assesses the share of government revenue used for debt repayment?",
        "options": [
          {
            "text": "The debt service-to-revenue ratio",
            "correct": true
          },
          {
            "text": "The debt-to-GDP ratio",
            "correct": false
          },
          {
            "text": "The interest-to-GDP ratio",
            "correct": false
          },
          {
            "text": "The debt-to-exports ratio",
            "correct": false
          }
        ],
        "explain": "The debt service-to-revenue ratio shows how much revenue goes to debt repayment."
      },
      {
        "q": "Which indicator shows the pressure of debt service on export income?",
        "options": [
          {
            "text": "The debt service-to-exports ratio",
            "correct": true
          },
          {
            "text": "The interest-to-GDP ratio",
            "correct": false
          },
          {
            "text": "The debt-to-GDP ratio",
            "correct": false
          },
          {
            "text": "The debt service-to-revenue ratio",
            "correct": false
          }
        ],
        "explain": "The debt service-to-exports ratio shows the pressure of debt service on export income."
      },
      {
        "q": "Debt rescheduling is:",
        "options": [
          {
            "text": "A bilateral postponement of debt service with new, extended maturities",
            "correct": true
          },
          {
            "text": "A complete cancellation of all debt",
            "correct": false
          },
          {
            "text": "A change that never affects payment dates",
            "correct": false
          },
          {
            "text": "A measure that applies only to private firms",
            "correct": false
          }
        ],
        "explain": "Rescheduling is a bilateral postponement of debt service with extended maturities."
      },
      {
        "q": "Debt restructuring:",
        "options": [
          {
            "text": "Alters the original terms — e.g. lower interest, extended maturity, or partial forgiveness",
            "correct": true
          },
          {
            "text": "Only postpones payments with no change to terms",
            "correct": false
          },
          {
            "text": "Is identical to issuing new treasury bills",
            "correct": false
          },
          {
            "text": "Always cancels the debt entirely",
            "correct": false
          }
        ],
        "explain": "Restructuring alters the original terms of the debt and may involve third parties and partial forgiveness."
      }
    ]
  },
  "3": {
    "pass_mark": 75,
    "ask": 20,
    "minutes": 20,
    "title": "Final Assessment",
    "intro": "This assessment has 40 questions in its bank; you will be asked a randomly selected 20, with a 20-minute time limit. The question order and the answer options are shuffled on every attempt, so refreshing or retaking the assessment mixes in new questions. You need 75% to pass and earn your certificate.",
    "questions": [
      {
        "q": "Which statement best defines Government Finance Statistics (GFS)?",
        "options": [
          {
            "text": "A standardized system that tracks how governments earn, spend, borrow and manage resources",
            "correct": true
          },
          {
            "text": "A register of commercial bank interest rates",
            "correct": false
          },
          {
            "text": "A list of private company profits",
            "correct": false
          },
          {
            "text": "A climate-monitoring tool",
            "correct": false
          }
        ],
        "explain": "GFS is a standardized system that tracks how governments earn, spend, borrow and manage resources — a financial health check for government."
      },
      {
        "q": "What is the EAC fiscal-deficit (including grants) goal referenced for GFS monitoring?",
        "options": [
          {
            "text": "A fiscal deficit (including grants) of no more than 3% of GDP",
            "correct": true
          },
          {
            "text": "6% of GDP",
            "correct": false
          },
          {
            "text": "50% of GDP",
            "correct": false
          },
          {
            "text": "10% of GDP",
            "correct": false
          }
        ],
        "explain": "The EAMU convergence ceiling for the fiscal deficit including grants is 3% of GDP (excluding grants it is 6%)."
      },
      {
        "q": "Which manual is used to compile GFS, and what is its latest version?",
        "options": [
          {
            "text": "The IMF's Government Finance Statistics Manual; GFSM 2014",
            "correct": true
          },
          {
            "text": "The Balance of Payments Manual; BPM7",
            "correct": false
          },
          {
            "text": "The System of National Accounts; SNA 1993",
            "correct": false
          },
          {
            "text": "The IMTS compilers guide",
            "correct": false
          }
        ],
        "explain": "GFS is compiled using the IMF's Government Finance Statistics Manual (GFSM); the latest version is GFSM 2014."
      },
      {
        "q": "GFSM 2014 is aligned with which other international framework?",
        "options": [
          {
            "text": "The System of National Accounts (SNA)",
            "correct": true
          },
          {
            "text": "The COFOG tax code",
            "correct": false
          },
          {
            "text": "The Basel Standards",
            "correct": false
          },
          {
            "text": "The GATS modes of supply",
            "correct": false
          }
        ],
        "explain": "GFSM 2014 is aligned with other macroeconomic frameworks such as the System of National Accounts (SNA)."
      },
      {
        "q": "Cash accounting records:",
        "options": [
          {
            "text": "Actual cash received or paid",
            "correct": true
          },
          {
            "text": "Transactions when they occur regardless of cash",
            "correct": false
          },
          {
            "text": "Only foreign-currency items",
            "correct": false
          },
          {
            "text": "Only year-end balances",
            "correct": false
          }
        ],
        "explain": "Cash accounting records actual cash received or paid — similar to household budgeting."
      },
      {
        "q": "Because most EAC Partner States are transitioning from cash to accrual, transactions are recorded on a:",
        "options": [
          {
            "text": "Modified cash basis",
            "correct": true
          },
          {
            "text": "Pure accrual basis",
            "correct": false
          },
          {
            "text": "Commitment basis",
            "correct": false
          },
          {
            "text": "Customs basis",
            "correct": false
          }
        ],
        "explain": "GFSM 2014 recommends accrual, but EAC states in transition record on a modified cash basis."
      },
      {
        "q": "In the GFSM 2014 framework, the closing balance sheet equals:",
        "options": [
          {
            "text": "The opening balance sheet plus the period's flows",
            "correct": true
          },
          {
            "text": "Only the period's transactions",
            "correct": false
          },
          {
            "text": "Total revenue minus total expenditure",
            "correct": false
          },
          {
            "text": "The central bank balance sheet",
            "correct": false
          }
        ],
        "explain": "Opening stocks plus the flows during the period (transactions and other economic flows) give the closing stocks."
      },
      {
        "q": "Which items are recorded as revenue in GFS?",
        "options": [
          {
            "text": "Taxes, social contributions, grants and other revenue",
            "correct": true
          },
          {
            "text": "Compensation of employees and subsidies",
            "correct": false
          },
          {
            "text": "Loans issued by government",
            "correct": false
          },
          {
            "text": "Infrastructure and machinery",
            "correct": false
          }
        ],
        "explain": "Revenue comprises taxes, social contributions, grants and other revenue."
      },
      {
        "q": "Compensation of employees, use of goods and services, interest and subsidies are examples of:",
        "options": [
          {
            "text": "Expense",
            "correct": true
          },
          {
            "text": "Revenue",
            "correct": false
          },
          {
            "text": "Financial assets",
            "correct": false
          },
          {
            "text": "Non-financial assets",
            "correct": false
          }
        ],
        "explain": "These are components of expense."
      },
      {
        "q": "Fixed assets, inventories, valuables and non-produced assets are recorded under:",
        "options": [
          {
            "text": "Net investment in non-financial assets",
            "correct": true
          },
          {
            "text": "Revenue",
            "correct": false
          },
          {
            "text": "Liabilities",
            "correct": false
          },
          {
            "text": "Financial assets",
            "correct": false
          }
        ],
        "explain": "These fall under the net investment in non-financial assets (e.g. infrastructure, machinery)."
      },
      {
        "q": "Net lending/net borrowing (the fiscal balance) is:",
        "options": [
          {
            "text": "Total revenue minus total expenditure",
            "correct": true
          },
          {
            "text": "Total assets minus total liabilities",
            "correct": false
          },
          {
            "text": "Revenue as a percentage of GDP",
            "correct": false
          },
          {
            "text": "The policy interest rate",
            "correct": false
          }
        ],
        "explain": "Net lending/net borrowing is total revenue minus total expenditure."
      },
      {
        "q": "The fiscal balance is financed by:",
        "options": [
          {
            "text": "Transactions in financial assets and the net incurrence of liabilities",
            "correct": true
          },
          {
            "text": "Revenue and expense only",
            "correct": false
          },
          {
            "text": "Non-financial assets only",
            "correct": false
          },
          {
            "text": "Grants from the central bank",
            "correct": false
          }
        ],
        "explain": "Financing comes from transactions in financial assets and the net incurrence of liabilities."
      },
      {
        "q": "A government runs a fiscal surplus when:",
        "options": [
          {
            "text": "Revenue exceeds expenditure",
            "correct": true
          },
          {
            "text": "Expenditure exceeds revenue",
            "correct": false
          },
          {
            "text": "Assets equal liabilities",
            "correct": false
          },
          {
            "text": "Debt exceeds 50% of GDP",
            "correct": false
          }
        ],
        "explain": "A surplus arises when revenue exceeds expenditure; a deficit when expenditure exceeds revenue."
      },
      {
        "q": "The public sector covered by GFS consists of:",
        "options": [
          {
            "text": "General government and public corporations",
            "correct": true
          },
          {
            "text": "Only the central government",
            "correct": false
          },
          {
            "text": "Private banks and households",
            "correct": false
          },
          {
            "text": "Insurance corporations only",
            "correct": false
          }
        ],
        "explain": "The public sector is general government plus public corporations."
      },
      {
        "q": "Which of the following belongs to general government?",
        "options": [
          {
            "text": "Local governments",
            "correct": true
          },
          {
            "text": "The central bank",
            "correct": false
          },
          {
            "text": "Public nonfinancial corporations",
            "correct": false
          },
          {
            "text": "Public deposit-taking corporations",
            "correct": false
          }
        ],
        "explain": "General government covers central, state/provincial and local governments; the central bank and public corporations are not general government."
      },
      {
        "q": "The central bank is classified within:",
        "options": [
          {
            "text": "Public corporations (public financial corporations)",
            "correct": true
          },
          {
            "text": "General government",
            "correct": false
          },
          {
            "text": "Households",
            "correct": false
          },
          {
            "text": "Non-financial corporations of the private sector",
            "correct": false
          }
        ],
        "explain": "The central bank is a public financial corporation within public corporations."
      },
      {
        "q": "Which is a source of GFS data?",
        "options": [
          {
            "text": "Statements from national revenue authorities",
            "correct": true
          },
          {
            "text": "Household grocery receipts",
            "correct": false
          },
          {
            "text": "Stock-market tickers",
            "correct": false
          },
          {
            "text": "Advertising spend data",
            "correct": false
          }
        ],
        "explain": "GFS sources include statements from national revenue authorities, treasury and accounting systems, budget execution reports, central bank data, and public entities' financial statements."
      },
      {
        "q": "The functional classification (COFOG) classifies spending by:",
        "options": [
          {
            "text": "Its purpose — health, education, defence",
            "correct": true
          },
          {
            "text": "The economic nature of the transaction",
            "correct": false
          },
          {
            "text": "The currency of payment",
            "correct": false
          },
          {
            "text": "The maturity of debt",
            "correct": false
          }
        ],
        "explain": "COFOG classifies by purpose; the economic classification classifies by the nature of the transaction."
      },
      {
        "q": "The economic classification of expense classifies expenditure by:",
        "options": [
          {
            "text": "The economic nature of the transaction (e.g. compensation of employees, goods and services)",
            "correct": true
          },
          {
            "text": "The purpose of the spending",
            "correct": false
          },
          {
            "text": "The geographic region",
            "correct": false
          },
          {
            "text": "The donor of grants",
            "correct": false
          }
        ],
        "explain": "The economic classification is based on the economic nature of the transaction."
      },
      {
        "q": "What is the primary objective of GFS?",
        "options": [
          {
            "text": "To provide reliable, consistent information on government financial operations for decision-making and monitoring",
            "correct": true
          },
          {
            "text": "To set commercial bank lending rates",
            "correct": false
          },
          {
            "text": "To audit private companies",
            "correct": false
          },
          {
            "text": "To forecast the weather",
            "correct": false
          }
        ],
        "explain": "GFS provides reliable, consistent information on government operations for decision-making, policy analysis and economic monitoring."
      },
      {
        "q": "Which indicators are commonly used in GFS international comparisons?",
        "options": [
          {
            "text": "Revenue as a % of GDP, tax revenue as a % of GDP, public investment as a % of GDP",
            "correct": true
          },
          {
            "text": "Commercial bank deposit and lending rates",
            "correct": false
          },
          {
            "text": "Household grocery prices and rents",
            "correct": false
          },
          {
            "text": "Company share prices and dividends",
            "correct": false
          }
        ],
        "explain": "International comparisons use revenue as a % of GDP, tax revenue as a % of GDP, and public investment as a % of GDP."
      },
      {
        "q": "The EAMU convergence ceiling for the fiscal deficit including grants is:",
        "options": [
          {
            "text": "3 percent of GDP",
            "correct": true
          },
          {
            "text": "6 percent of GDP",
            "correct": false
          },
          {
            "text": "50 percent of GDP",
            "correct": false
          },
          {
            "text": "10 percent of GDP",
            "correct": false
          }
        ],
        "explain": "Including grants the ceiling is 3% of GDP."
      },
      {
        "q": "The EAMU convergence ceiling for the fiscal deficit excluding grants is:",
        "options": [
          {
            "text": "6 percent of GDP",
            "correct": true
          },
          {
            "text": "3 percent of GDP",
            "correct": false
          },
          {
            "text": "50 percent of GDP",
            "correct": false
          },
          {
            "text": "12 percent of GDP",
            "correct": false
          }
        ],
        "explain": "Excluding grants the ceiling is 6% of GDP."
      },
      {
        "q": "The EAMU ceiling for gross public debt is:",
        "options": [
          {
            "text": "50 percent of GDP in net present value terms",
            "correct": true
          },
          {
            "text": "3 percent of GDP",
            "correct": false
          },
          {
            "text": "6 percent of GDP",
            "correct": false
          },
          {
            "text": "100 percent of GDP",
            "correct": false
          }
        ],
        "explain": "Gross public debt is capped at 50% of GDP in net present value terms."
      },
      {
        "q": "The net worth of a government is:",
        "options": [
          {
            "text": "Total assets (financial and non-financial) minus total liabilities",
            "correct": true
          },
          {
            "text": "Total revenue minus total expenditure",
            "correct": false
          },
          {
            "text": "Revenue as a percentage of GDP",
            "correct": false
          },
          {
            "text": "The sum of all grants received",
            "correct": false
          }
        ],
        "explain": "Net worth is total assets minus total liabilities."
      },
      {
        "q": "Infrastructure, buildings, equipment and land are examples of:",
        "options": [
          {
            "text": "Non-financial assets",
            "correct": true
          },
          {
            "text": "Financial assets",
            "correct": false
          },
          {
            "text": "Liabilities",
            "correct": false
          },
          {
            "text": "Revenue",
            "correct": false
          }
        ],
        "explain": "Non-financial assets are economic assets other than financial assets — tangible and intangible, such as infrastructure, buildings, equipment and land."
      },
      {
        "q": "In GFS, debt forgiveness is recorded as:",
        "options": [
          {
            "text": "A capital grant (revenue)",
            "correct": true
          },
          {
            "text": "An expense",
            "correct": false
          },
          {
            "text": "A non-financial asset",
            "correct": false
          },
          {
            "text": "A reduction in revenue",
            "correct": false
          }
        ],
        "explain": "Debt forgiveness is recorded as a capital grant (revenue)."
      },
      {
        "q": "Debt rescheduling is reflected in GFS as:",
        "options": [
          {
            "text": "Changes in liabilities and interest payments",
            "correct": true
          },
          {
            "text": "A capital grant",
            "correct": false
          },
          {
            "text": "An asset sale",
            "correct": false
          },
          {
            "text": "Revenue from taxes",
            "correct": false
          }
        ],
        "explain": "Debt rescheduling is reflected as changes in liabilities and interest payments."
      },
      {
        "q": "A debt-for-equity swap is treated as:",
        "options": [
          {
            "text": "A financial transaction affecting both assets and liabilities",
            "correct": true
          },
          {
            "text": "A capital grant",
            "correct": false
          },
          {
            "text": "An expense",
            "correct": false
          },
          {
            "text": "A non-financial asset",
            "correct": false
          }
        ],
        "explain": "A debt-for-equity swap is a financial transaction affecting both assets and liabilities."
      },
      {
        "q": "Corporate income tax and royalties from extraction companies are classified as:",
        "options": [
          {
            "text": "Taxes",
            "correct": true
          },
          {
            "text": "Dividends",
            "correct": false
          },
          {
            "text": "Asset sales",
            "correct": false
          },
          {
            "text": "Liabilities",
            "correct": false
          }
        ],
        "explain": "Taxes on extraction companies include corporate income tax and royalties."
      },
      {
        "q": "One-off revenues from the sale of natural resource assets are classified as:",
        "options": [
          {
            "text": "Asset sales",
            "correct": true
          },
          {
            "text": "Taxes",
            "correct": false
          },
          {
            "text": "Dividends",
            "correct": false
          },
          {
            "text": "Grants",
            "correct": false
          }
        ],
        "explain": "Asset sales are one-off revenues from the sale of natural resource assets."
      },
      {
        "q": "Why are governments encouraged to distinguish recurrent revenues from one-off revenues?",
        "options": [
          {
            "text": "To ensure fiscal sustainability",
            "correct": true
          },
          {
            "text": "To raise the policy rate",
            "correct": false
          },
          {
            "text": "To avoid publishing data",
            "correct": false
          },
          {
            "text": "To increase bank deposits",
            "correct": false
          }
        ],
        "explain": "Separating recurrent (taxes, royalties) from one-off (asset sales) revenues helps ensure fiscal sustainability."
      },
      {
        "q": "GFS supports the EAC by promoting:",
        "options": [
          {
            "text": "Fiscal transparency, debt sustainability and regional convergence",
            "correct": true
          },
          {
            "text": "Higher household spending",
            "correct": false
          },
          {
            "text": "Private company profits",
            "correct": false
          },
          {
            "text": "Lower deposit interest",
            "correct": false
          }
        ],
        "explain": "GFS supports fiscal transparency, debt sustainability and regional convergence."
      },
      {
        "q": "Which of these is one of the questions GFS helps answer?",
        "options": [
          {
            "text": "Are public debts sustainable?",
            "correct": true
          },
          {
            "text": "What is tomorrow's weather?",
            "correct": false
          },
          {
            "text": "What price should a shop charge?",
            "correct": false
          },
          {
            "text": "Which film should I watch?",
            "correct": false
          }
        ],
        "explain": "GFS helps assess whether tax revenues are used effectively, public debts are sustainable, and public services are adequately funded."
      },
      {
        "q": "Revenue less expense, before subtracting investment in non-financial assets, gives the:",
        "options": [
          {
            "text": "Net operating balance",
            "correct": true
          },
          {
            "text": "Debt-to-GDP ratio",
            "correct": false
          },
          {
            "text": "Gross public debt",
            "correct": false
          },
          {
            "text": "Reserve requirement",
            "correct": false
          }
        ],
        "explain": "Revenue minus expense is the net operating balance; subtracting net investment in non-financial assets then gives net lending/borrowing."
      },
      {
        "q": "Issuing debt securities to cover a deficit is recorded under:",
        "options": [
          {
            "text": "The net incurrence of liabilities",
            "correct": true
          },
          {
            "text": "Revenue",
            "correct": false
          },
          {
            "text": "Non-financial assets",
            "correct": false
          },
          {
            "text": "Compensation of employees",
            "correct": false
          }
        ],
        "explain": "Financing the balance runs through transactions in financial assets and the net incurrence of liabilities, such as issuing debt securities."
      },
      {
        "q": "Social security funds are part of:",
        "options": [
          {
            "text": "General government",
            "correct": true
          },
          {
            "text": "Public nonfinancial corporations",
            "correct": false
          },
          {
            "text": "The private sector",
            "correct": false
          },
          {
            "text": "Households",
            "correct": false
          }
        ],
        "explain": "Social security funds sit within general government (and may be shown as a separate subsector)."
      },
      {
        "q": "Treasury and accounting systems are an example of a:",
        "options": [
          {
            "text": "GFS data source",
            "correct": true
          },
          {
            "text": "Debt instrument",
            "correct": false
          },
          {
            "text": "Classification of revenue",
            "correct": false
          },
          {
            "text": "Convergence ceiling",
            "correct": false
          }
        ],
        "explain": "Treasury and accounting systems are one of the administrative sources GFS is compiled from."
      },
      {
        "q": "Public investment as a percent of GDP expresses:",
        "options": [
          {
            "text": "Investment in non-financial assets relative to the size of the economy",
            "correct": true
          },
          {
            "text": "The central bank policy rate",
            "correct": false
          },
          {
            "text": "Household savings",
            "correct": false
          },
          {
            "text": "Commercial lending rates",
            "correct": false
          }
        ],
        "explain": "It relates public investment (in non-financial assets) to the size of the economy for comparison."
      },
      {
        "q": "A debt-for-equity swap affects:",
        "options": [
          {
            "text": "Both assets and liabilities",
            "correct": true
          },
          {
            "text": "Revenue only",
            "correct": false
          },
          {
            "text": "Non-financial assets only",
            "correct": false
          },
          {
            "text": "Compensation of employees",
            "correct": false
          }
        ],
        "explain": "A debt-for-equity swap is a financial transaction affecting both assets and liabilities."
      }
    ]
  },
  "2": {
    "pass_mark": 75,
    "ask": 20,
    "title": "Final Assessment",
    "intro": "This assessment has 46 questions in its bank; you will be asked a randomly selected 20. The question order and the answer options are shuffled on every attempt, so refreshing or retaking the assessment mixes in new questions. You need 75% to pass and earn your certificate.",
    "questions": [
      {
        "q": "Financial Soundness Indicators (FSIs) help show:",
        "options": [
          {
            "text": "How healthy, stable and strong a country's financial system is",
            "correct": true
          },
          {
            "text": "The exchange rate for the day",
            "correct": false
          },
          {
            "text": "A company's marketing reach",
            "correct": false
          },
          {
            "text": "The weather outlook",
            "correct": false
          }
        ],
        "explain": "FSIs are numbers or measures that help show how healthy, stable and strong a country's financial system is."
      },
      {
        "q": "The EAC computes FSIs for how many sectors?",
        "options": [
          {
            "text": "Three",
            "correct": false
          },
          {
            "text": "Four",
            "correct": false
          },
          {
            "text": "Five",
            "correct": true
          },
          {
            "text": "Eight",
            "correct": false
          }
        ],
        "explain": "Five sectors: Deposit Takers, Other Financial Corporations, Households, Non-Financial Corporations and Real Estate Markets."
      },
      {
        "q": "Deposit Takers are best defined as:",
        "options": [
          {
            "text": "Institutions, such as banks, that accept deposits and use them to provide loans and other services",
            "correct": true
          },
          {
            "text": "Companies that only sell insurance",
            "correct": false
          },
          {
            "text": "Government tax offices",
            "correct": false
          },
          {
            "text": "Funds that invest only in real estate",
            "correct": false
          }
        ],
        "explain": "DTs are financial institutions, such as banks, that accept deposits from the public and use those funds to provide loans and other financial services."
      },
      {
        "q": "The FSIs for Deposit Takers are largely prepared in line with:",
        "options": [
          {
            "text": "The Basel Standards issued by the BCBS",
            "correct": true
          },
          {
            "text": "The GATS modes of supply",
            "correct": false
          },
          {
            "text": "The IMTS customs rules",
            "correct": false
          },
          {
            "text": "The Penetration Ratio",
            "correct": false
          }
        ],
        "explain": "DT FSIs follow the Basel Standards issued by the Basel Committee on Banking Supervision, covering capital, liquidity and leverage."
      },
      {
        "q": "Common Equity Tier 1 (CET1) is best described as:",
        "options": [
          {
            "text": "The highest-quality, most permanent form of a DT's capital",
            "correct": true
          },
          {
            "text": "Subordinated debt",
            "correct": false
          },
          {
            "text": "A type of nonperforming loan",
            "correct": false
          },
          {
            "text": "Money owed to depositors",
            "correct": false
          }
        ],
        "explain": "CET1 is the highest-quality, most permanent capital (mainly ordinary shares and retained earnings)."
      },
      {
        "q": "The EAC minimum regulatory CET1 ratio is:",
        "options": [
          {
            "text": "8.5 percent",
            "correct": true
          },
          {
            "text": "10 percent",
            "correct": false
          },
          {
            "text": "12 percent",
            "correct": false
          },
          {
            "text": "6 percent",
            "correct": false
          }
        ],
        "explain": "The EAC minimum CET1 ratio is 8.5 percent."
      },
      {
        "q": "The EAC minimum Tier 1 and total regulatory capital ratios are, respectively:",
        "options": [
          {
            "text": "10 percent and 12 percent",
            "correct": true
          },
          {
            "text": "8.5 percent and 10 percent",
            "correct": false
          },
          {
            "text": "12 percent and 15 percent",
            "correct": false
          },
          {
            "text": "5 percent and 8 percent",
            "correct": false
          }
        ],
        "explain": "The EAC minimum Tier 1 ratio is 10 percent and the total regulatory capital ratio is 12 percent."
      },
      {
        "q": "The leverage ratio serves mainly as:",
        "options": [
          {
            "text": "A safeguard against rapid asset growth without corresponding capital injection",
            "correct": true
          },
          {
            "text": "A measure of insurance penetration",
            "correct": false
          },
          {
            "text": "A profitability ratio",
            "correct": false
          },
          {
            "text": "A measure of digital lending",
            "correct": false
          }
        ],
        "explain": "The leverage ratio is a safeguard against rapid asset growth without corresponding capital injection."
      },
      {
        "q": "A loan becomes nonperforming (an NPL) when unpaid for:",
        "options": [
          {
            "text": "90 days",
            "correct": true
          },
          {
            "text": "30 days",
            "correct": false
          },
          {
            "text": "one year",
            "correct": false
          },
          {
            "text": "two years",
            "correct": false
          }
        ],
        "explain": "An NPL is a loan that has not been repaid for 90 days."
      },
      {
        "q": "Provisions to NPLs shows:",
        "options": [
          {
            "text": "The extent to which a DT has set aside funds to cover potential losses from its NPLs",
            "correct": true
          },
          {
            "text": "The DT's foreign-exchange exposure",
            "correct": false
          },
          {
            "text": "The share of loans to households",
            "correct": false
          },
          {
            "text": "The DT's market share",
            "correct": false
          }
        ],
        "explain": "It shows the extent to which a DT has set aside funds (provisions) to cover potential losses from its NPLs."
      },
      {
        "q": "Loan concentration by economic activity highlights the risk of:",
        "options": [
          {
            "text": "Lending to only a few sectors",
            "correct": true
          },
          {
            "text": "Holding too much cash",
            "correct": false
          },
          {
            "text": "Paying staff too much",
            "correct": false
          },
          {
            "text": "Issuing too few loans",
            "correct": false
          }
        ],
        "explain": "It measures how loans are spread across sectors and the risk of lending predominantly to a few sectors."
      },
      {
        "q": "Return on Assets (ROA) measures:",
        "options": [
          {
            "text": "The profit earned from the assets owned or controlled and investments made by the DT",
            "correct": true
          },
          {
            "text": "The number of branches a DT has",
            "correct": false
          },
          {
            "text": "The DT's deposit base",
            "correct": false
          },
          {
            "text": "The DT's foreign-currency loans",
            "correct": false
          }
        ],
        "explain": "ROA is the profit or income earned from the assets owned or controlled and investments made by the DT."
      },
      {
        "q": "Return on Equity (ROE) measures:",
        "options": [
          {
            "text": "The profit earned from the DT's own funds (capital)",
            "correct": true
          },
          {
            "text": "The proportion of nonperforming loans",
            "correct": false
          },
          {
            "text": "The liquidity coverage over 30 days",
            "correct": false
          },
          {
            "text": "The spread between lending and deposit rates",
            "correct": false
          }
        ],
        "explain": "ROE is the profit or income earned from the DT's own funds (capital)."
      },
      {
        "q": "Other than easily tradeable securities, liquid assets should have a maturity of:",
        "options": [
          {
            "text": "3 months or less",
            "correct": true
          },
          {
            "text": "6 months or less",
            "correct": false
          },
          {
            "text": "one year or less",
            "correct": false
          },
          {
            "text": "any length",
            "correct": false
          }
        ],
        "explain": "Liquid assets should have a maturity of 3 months or less, except for easily tradeable securities."
      },
      {
        "q": "Liquid Assets to Total Assets indicates:",
        "options": [
          {
            "text": "How much of a bank's assets can be quickly used to cover cash needs such as customers' deposit withdrawals",
            "correct": true
          },
          {
            "text": "The DT's profitability",
            "correct": false
          },
          {
            "text": "The DT's staff costs",
            "correct": false
          },
          {
            "text": "The number of digital loans",
            "correct": false
          }
        ],
        "explain": "It indicates how much of a bank's assets can be quickly used to cover its cash needs, such as customers' deposit withdrawals."
      },
      {
        "q": "The Liquidity Coverage Ratio (LCR) covers an urgent cash demand over:",
        "options": [
          {
            "text": "30 days",
            "correct": true
          },
          {
            "text": "90 days",
            "correct": false
          },
          {
            "text": "one year",
            "correct": false
          },
          {
            "text": "five years",
            "correct": false
          }
        ],
        "explain": "The LCR measures the ability to meet an urgent demand for cash in a 30-day period; the EAC minimum is 100 percent."
      },
      {
        "q": "The Net Stable Funding Ratio (NSFR) covers a demand for cash over:",
        "options": [
          {
            "text": "one year",
            "correct": true
          },
          {
            "text": "30 days",
            "correct": false
          },
          {
            "text": "90 days",
            "correct": false
          },
          {
            "text": "ten years",
            "correct": false
          }
        ],
        "explain": "The NSFR measures the ability to meet a demand for cash over a one-year period; the EAC minimum is 100 percent."
      },
      {
        "q": "The net open position in foreign exchange to capital indicates vulnerability to:",
        "options": [
          {
            "text": "Changes in the value of foreign currency",
            "correct": true
          },
          {
            "text": "Rising salaries",
            "correct": false
          },
          {
            "text": "Loan concentration",
            "correct": false
          },
          {
            "text": "Falling deposit numbers",
            "correct": false
          }
        ],
        "explain": "It indicates how much a DT could be affected by changes in the value of foreign currency."
      },
      {
        "q": "How many additional FSIs are there for Deposit Takers?",
        "options": [
          {
            "text": "Twelve",
            "correct": true
          },
          {
            "text": "Five",
            "correct": false
          },
          {
            "text": "Thirteen",
            "correct": false
          },
          {
            "text": "Twenty",
            "correct": false
          }
        ],
        "explain": "There are 12 additional FSIs for DTs (the EAC-specific set has 13)."
      },
      {
        "q": "Digital loans to gross loans captures the risk that:",
        "options": [
          {
            "text": "Loans approved quickly online with limited information may not be repaid",
            "correct": true
          },
          {
            "text": "Deposits are too high",
            "correct": false
          },
          {
            "text": "Branches are too few",
            "correct": false
          },
          {
            "text": "Staff costs are rising",
            "correct": false
          }
        ],
        "explain": "It indicates vulnerability from online lending, where loans are approved quickly with limited information, reducing the chance of repayment."
      },
      {
        "q": "A wide spread between the highest and lowest interbank loan rates may indicate:",
        "options": [
          {
            "text": "Stress or lack of trust in the banking system",
            "correct": true
          },
          {
            "text": "Strong profitability",
            "correct": false
          },
          {
            "text": "High liquidity",
            "correct": false
          },
          {
            "text": "Low foreign-currency exposure",
            "correct": false
          }
        ],
        "explain": "A wide gap may show stress or a lack of trust in the banking system."
      },
      {
        "q": "Life Insurance Companies (LICs) offer:",
        "options": [
          {
            "text": "Long-term cover such as life and pensions",
            "correct": true
          },
          {
            "text": "Only motor insurance",
            "correct": false
          },
          {
            "text": "Short-term health cover settled within a year",
            "correct": false
          },
          {
            "text": "Deposit accounts",
            "correct": false
          }
        ],
        "explain": "LICs offer long-term services such as life cover and pensions, where obligations stretch into the future."
      },
      {
        "q": "Non-Life (General) Insurance Companies (NLICs) typically settle claims:",
        "options": [
          {
            "text": "Within a year",
            "correct": true
          },
          {
            "text": "Over 20 years",
            "correct": false
          },
          {
            "text": "Only at retirement",
            "correct": false
          },
          {
            "text": "Never",
            "correct": false
          }
        ],
        "explain": "NLICs offer short-term cover (health, motor, property) where claims are usually settled within a year."
      },
      {
        "q": "NLICs are encouraged to keep the combined ratio:",
        "options": [
          {
            "text": "Below 100 percent",
            "correct": true
          },
          {
            "text": "Above 100 percent",
            "correct": false
          },
          {
            "text": "Above 150 percent",
            "correct": false
          },
          {
            "text": "At exactly 200 percent",
            "correct": false
          }
        ],
        "explain": "A combined ratio below 100 percent indicates the NLIC is profitable in its core business."
      },
      {
        "q": "Shareholders' equity to invested assets acts as:",
        "options": [
          {
            "text": "A safeguard against excessive asset growth without corresponding capital injection",
            "correct": true
          },
          {
            "text": "A measure of premium growth",
            "correct": false
          },
          {
            "text": "A liquidity ratio",
            "correct": false
          },
          {
            "text": "A measure of digital lending",
            "correct": false
          }
        ],
        "explain": "It safeguards against excessive asset growth without a corresponding capital injection and shows the ability to absorb losses."
      },
      {
        "q": "The retention ratio measures:",
        "options": [
          {
            "text": "The proportion of premiums retained rather than passed to reinsurance",
            "correct": true
          },
          {
            "text": "The proportion of assets in real estate",
            "correct": false
          },
          {
            "text": "The insurer's ROE",
            "correct": false
          },
          {
            "text": "The penetration of insurance in the economy",
            "correct": false
          }
        ],
        "explain": "It shows how much risk an IC keeps for itself versus passing on to reinsurance."
      },
      {
        "q": "The penetration ratio indicates:",
        "options": [
          {
            "text": "How developed the insurance sector is within the economy",
            "correct": true
          },
          {
            "text": "The insurer's staff costs",
            "correct": false
          },
          {
            "text": "The number of claims paid",
            "correct": false
          },
          {
            "text": "The maturity of investments",
            "correct": false
          }
        ],
        "explain": "It measures the level of insurance coverage in an economy; generally, a higher ratio means a more developed sector."
      },
      {
        "q": "Net claims to net premiums compares:",
        "options": [
          {
            "text": "What an IC pays in claims with what it receives in premiums",
            "correct": true
          },
          {
            "text": "Assets with liabilities",
            "correct": false
          },
          {
            "text": "Capital with risk-weighted assets",
            "correct": false
          },
          {
            "text": "Loans with deposits",
            "correct": false
          }
        ],
        "explain": "It measures the proportion of claims paid relative to premiums received; a lower ratio indicates the IC receives enough to cover claims."
      },
      {
        "q": "ICs assets to GDP shows:",
        "options": [
          {
            "text": "The size of insurance corporations relative to the overall economy",
            "correct": true
          },
          {
            "text": "The insurer's profitability",
            "correct": false
          },
          {
            "text": "The number of policyholders",
            "correct": false
          },
          {
            "text": "The reinsurance retained",
            "correct": false
          }
        ],
        "explain": "It shows the size of ICs relative to the economy; a higher ratio shows an increasing share and uptake of insurance products."
      },
      {
        "q": "Pension Funds (PFs) collect contributions and:",
        "options": [
          {
            "text": "Invest them and pay them out with interest to support workers after retirement",
            "correct": true
          },
          {
            "text": "Lend them to governments only",
            "correct": false
          },
          {
            "text": "Use them to buy insurance",
            "correct": false
          },
          {
            "text": "Keep them as idle cash",
            "correct": false
          }
        ],
        "explain": "PFs collect contributions from workers and employers, invest the money, and pay it out with interest after retirement."
      },
      {
        "q": "The pension-fund liquidity ratio covers obligations over:",
        "options": [
          {
            "text": "12 months",
            "correct": true
          },
          {
            "text": "30 days",
            "correct": false
          },
          {
            "text": "90 days",
            "correct": false
          },
          {
            "text": "ten years",
            "correct": false
          }
        ],
        "explain": "It checks whether a PF has enough accessible funds to cover short-term (12-month) obligations — members' benefits."
      },
      {
        "q": "The funding ratio indicates whether a PF's available assets are enough to:",
        "options": [
          {
            "text": "Cover the future benefits it intends to pay",
            "correct": true
          },
          {
            "text": "Pay this month's salaries",
            "correct": false
          },
          {
            "text": "Buy a new office",
            "correct": false
          },
          {
            "text": "Reduce dependency",
            "correct": false
          }
        ],
        "explain": "The funding ratio shows whether available assets are enough to cover future benefit payments."
      },
      {
        "q": "A high dependency ratio implies:",
        "options": [
          {
            "text": "The PF does not have enough active members to pay its retirees",
            "correct": true
          },
          {
            "text": "The PF has too much cash",
            "correct": false
          },
          {
            "text": "The PF is over-invested in equities",
            "correct": false
          },
          {
            "text": "The PF has no retirees",
            "correct": false
          }
        ],
        "explain": "It compares retirees receiving benefits with active contributors; a high ratio means too few active members to support retirees."
      },
      {
        "q": "For the pension-fund efficiency ratio, a lower value means:",
        "options": [
          {
            "text": "Minimal operational cost",
            "correct": true
          },
          {
            "text": "Higher operational cost",
            "correct": false
          },
          {
            "text": "A larger dependency ratio",
            "correct": false
          },
          {
            "text": "More real-estate exposure",
            "correct": false
          }
        ],
        "explain": "Lower = minimal operational cost — the PF spends little to generate income."
      },
      {
        "q": "A Money Market Fund invests in income-generating assets owned for:",
        "options": [
          {
            "text": "One year or less (short-term)",
            "correct": true
          },
          {
            "text": "More than ten years",
            "correct": false
          },
          {
            "text": "Exactly five years",
            "correct": false
          },
          {
            "text": "With no maturity",
            "correct": false
          }
        ],
        "explain": "MMFs invest in short-term assets owned for one year or less, such as Treasury bills."
      },
      {
        "q": "Sectoral distribution of MMFs' investments highlights the risk of:",
        "options": [
          {
            "text": "Investing predominantly in only a few sectors",
            "correct": true
          },
          {
            "text": "Holding too much cash",
            "correct": false
          },
          {
            "text": "Paying staff too much",
            "correct": false
          },
          {
            "text": "Issuing loans",
            "correct": false
          }
        ],
        "explain": "Concentration in a few sectors can cause significant losses if those sectors underperform; spreading across sectors reduces potential losses."
      },
      {
        "q": "A higher 'investment in real estate to total assets' for a PF means:",
        "options": [
          {
            "text": "The PF is more vulnerable to changes in the value of the real estate market",
            "correct": true
          },
          {
            "text": "The PF holds no property",
            "correct": false
          },
          {
            "text": "The PF has more cash",
            "correct": false
          },
          {
            "text": "The PF has fewer members",
            "correct": false
          }
        ],
        "explain": "A higher ratio shows the PF is highly vulnerable to changes in the value of the real estate market."
      },
      {
        "q": "The Residential Property Price Index (RPPI) measures price changes for:",
        "options": [
          {
            "text": "Apartments and houses purchased by households for own use",
            "correct": true
          },
          {
            "text": "Offices and warehouses",
            "correct": false
          },
          {
            "text": "Government bonds",
            "correct": false
          },
          {
            "text": "Foreign currency",
            "correct": false
          }
        ],
        "explain": "The RPPI measures the change in prices of apartments and houses purchased by households for their own use."
      },
      {
        "q": "Why does a sharp fall in property prices matter for Deposit Takers?",
        "options": [
          {
            "text": "It may shrink collateral value, creating a loan exposure",
            "correct": true
          },
          {
            "text": "It raises the CET1 minimum",
            "correct": false
          },
          {
            "text": "It increases the dependency ratio",
            "correct": false
          },
          {
            "text": "It has no effect",
            "correct": false
          }
        ],
        "explain": "A sharp drop in property prices may shrink collateral value, creating a loan exposure for DTs."
      },
      {
        "q": "For NFCs, Return on Equity (ROE) is:",
        "options": [
          {
            "text": "Profit earned from NFCs' own funds",
            "correct": true
          },
          {
            "text": "Debt borrowed abroad",
            "correct": false
          },
          {
            "text": "Operational cost to income",
            "correct": false
          },
          {
            "text": "Loans spread across sectors",
            "correct": false
          }
        ],
        "explain": "For NFCs, ROE is the profit earned from their own funds."
      },
      {
        "q": "Debt-service coverage shows whether NFCs can:",
        "options": [
          {
            "text": "Repay their loans using their income",
            "correct": true
          },
          {
            "text": "Attract more customers",
            "correct": false
          },
          {
            "text": "Reduce staff numbers",
            "correct": false
          },
          {
            "text": "Increase property prices",
            "correct": false
          }
        ],
        "explain": "It measures NFCs' ability to repay their loans using their income; a lower ratio implies they can't fully repay liabilities from own income."
      },
      {
        "q": "The interest coverage ratio measures an NFC's ability to:",
        "options": [
          {
            "text": "Repay the interest on funds borrowed using their income",
            "correct": true
          },
          {
            "text": "Repay all principal immediately",
            "correct": false
          },
          {
            "text": "Pay dividends",
            "correct": false
          },
          {
            "text": "Buy real estate",
            "correct": false
          }
        ],
        "explain": "It is the ability to repay the interest on funds borrowed using their income."
      },
      {
        "q": "For FSI purposes, a household is:",
        "options": [
          {
            "text": "People who live together and share some money and expenses (one person or a family)",
            "correct": true
          },
          {
            "text": "Only a married couple",
            "correct": false
          },
          {
            "text": "A registered company",
            "correct": false
          },
          {
            "text": "A bank branch",
            "correct": false
          }
        ],
        "explain": "A household can be one person or a group, such as a family, sharing money and expenses."
      },
      {
        "q": "A higher household debt-to-income ratio implies:",
        "options": [
          {
            "text": "Households have borrowed a lot relative to income (household indebtedness)",
            "correct": true
          },
          {
            "text": "Households have no debt",
            "correct": false
          },
          {
            "text": "The economy has shrunk",
            "correct": false
          },
          {
            "text": "Banks hold more capital",
            "correct": false
          }
        ],
        "explain": "A higher ratio signals household indebtedness — borrowing is large relative to income."
      },
      {
        "q": "A high total-debt-to-equity ratio for NFCs means:",
        "options": [
          {
            "text": "NFCs are heavily indebted, raising vulnerability to higher lending rates",
            "correct": true
          },
          {
            "text": "NFCs have no debt",
            "correct": false
          },
          {
            "text": "NFCs are very liquid",
            "correct": false
          },
          {
            "text": "NFCs hold mostly cash",
            "correct": false
          }
        ],
        "explain": "A high ratio means NFCs are heavily indebted, which raises vulnerability to an increase in lending rates."
      },
      {
        "q": "The Commercial Property Price Index (CPPI) covers:",
        "options": [
          {
            "text": "Offices, shops, rental apartments, factories and warehouses",
            "correct": true
          },
          {
            "text": "Only houses and apartments",
            "correct": false
          },
          {
            "text": "Treasury bills",
            "correct": false
          },
          {
            "text": "Pension contributions",
            "correct": false
          }
        ],
        "explain": "The CPPI measures the change in prices of commercial properties (offices, shops, rental apartments, factories and warehouses)."
      }
    ]
  },
  "5": {
    "pass_mark": 75,
    "ask": 20,
    "minutes": 20,
    "title": "Final Assessment",
    "intro": "This assessment has 43 questions in its bank; you will be asked a randomly selected 20, with a 20-minute time limit. The question order and the answer options are shuffled on every attempt, so refreshing or retaking the assessment mixes in new questions. You need 75% to pass and earn your certificate.",
    "questions": [
      {
        "q": "In plain terms, what does Monetary &amp; Financial Statistics show?",
        "options": [
          {
            "text": "Who has money, who owes money, and how money flows through the economy",
            "correct": true
          },
          {
            "text": "Only the government's budget",
            "correct": false
          },
          {
            "text": "Retail shop prices",
            "correct": false
          },
          {
            "text": "Company profit forecasts",
            "correct": false
          }
        ],
        "explain": "MFS shows who has money, who owes money, and how money flows through the economy."
      },
      {
        "q": "How many broad institutional sectors are there in MFS?",
        "options": [
          {
            "text": "Five",
            "correct": true
          },
          {
            "text": "Three",
            "correct": false
          },
          {
            "text": "Seven",
            "correct": false
          },
          {
            "text": "Two",
            "correct": false
          }
        ],
        "explain": "There are five: households, financial corporations, non-financial corporations, general government and NPISH."
      },
      {
        "q": "What does NPISH stand for?",
        "options": [
          {
            "text": "Non-profit Institutions Serving Households",
            "correct": true
          },
          {
            "text": "National Public Insurance and Social Health",
            "correct": false
          },
          {
            "text": "Net Private Investment in Shares and Holdings",
            "correct": false
          },
          {
            "text": "None of the above",
            "correct": false
          }
        ],
        "explain": "NPISH = Non-profit Institutions Serving Households (e.g. churches, mission hospitals, NGOs)."
      },
      {
        "q": "An institutional unit is one that:",
        "options": [
          {
            "text": "Has its own balance sheet and can take on liabilities and contracts in its own name",
            "correct": true
          },
          {
            "text": "Is always owned by government",
            "correct": false
          },
          {
            "text": "Cannot borrow money",
            "correct": false
          },
          {
            "text": "Only exists abroad",
            "correct": false
          }
        ],
        "explain": "An institutional unit has its own balance sheet and can take on debts/liabilities and enter contracts on its own behalf."
      },
      {
        "q": "Which institution is a Depository Corporation (DC)?",
        "options": [
          {
            "text": "A commercial bank",
            "correct": true
          },
          {
            "text": "An insurance company",
            "correct": false
          },
          {
            "text": "A forex bureau",
            "correct": false
          },
          {
            "text": "A pension fund",
            "correct": false
          }
        ],
        "explain": "Commercial banks take deposits, so they are DCs. Insurance, forex bureaus and pension funds are OFCs."
      },
      {
        "q": "Which institution is an Other Financial Corporation (OFC)?",
        "options": [
          {
            "text": "A pension fund",
            "correct": true
          },
          {
            "text": "A commercial bank",
            "correct": false
          },
          {
            "text": "A deposit-taking SACCO",
            "correct": false
          },
          {
            "text": "A Money Market Fund",
            "correct": false
          }
        ],
        "explain": "Pension funds do not take deposits, so they are OFCs. The others are deposit-takers (DCs)."
      },
      {
        "q": "A non-resident is best defined as a unit whose:",
        "options": [
          {
            "text": "Main centre of economic interest is outside the domestic economy",
            "correct": true
          },
          {
            "text": "Owners are foreign",
            "correct": false
          },
          {
            "text": "Staff are foreign nationals",
            "correct": false
          },
          {
            "text": "Accounts are in foreign currency",
            "correct": false
          }
        ],
        "explain": "Residency follows the centre of economic interest, not nationality, ownership or currency."
      },
      {
        "q": "Public non-financial corporations are distinguished from general government because they:",
        "options": [
          {
            "text": "Have their own sources of funding and charge market prices",
            "correct": true
          },
          {
            "text": "Depend entirely on budget allocation",
            "correct": false
          },
          {
            "text": "Cannot be owned by government",
            "correct": false
          },
          {
            "text": "Issue currency",
            "correct": false
          }
        ],
        "explain": "Public non-financial corporations earn their own income (charging market prices); entities dependent on budget allocation are general government."
      },
      {
        "q": "Which of these is a Money Market Fund classified as in the EAC?",
        "options": [
          {
            "text": "An Other Depository Corporation (ODC)",
            "correct": true
          },
          {
            "text": "An Other Financial Corporation",
            "correct": false
          },
          {
            "text": "A non-financial corporation",
            "correct": false
          },
          {
            "text": "Part of general government",
            "correct": false
          }
        ],
        "explain": "In the EAC, Money Market Funds are treated as Other Depository Corporations (ODCs)."
      },
      {
        "q": "Money holding sectors are best described as:",
        "options": [
          {
            "text": "Users of money that do not create it",
            "correct": true
          },
          {
            "text": "Makers of money",
            "correct": false
          },
          {
            "text": "Only the central bank",
            "correct": false
          },
          {
            "text": "Only non-residents",
            "correct": false
          }
        ],
        "explain": "Money holding sectors use money to spend, save or invest but do not create it."
      },
      {
        "q": "Which sectors are the money issuing sectors?",
        "options": [
          {
            "text": "The Central Bank and ODCs",
            "correct": true
          },
          {
            "text": "Households and NPISH",
            "correct": false
          },
          {
            "text": "Central Government and non-residents",
            "correct": false
          },
          {
            "text": "OFCs and NFCs",
            "correct": false
          }
        ],
        "explain": "The Central Bank issues currency and ODCs create money by lending; together they are the money issuing sectors."
      },
      {
        "q": "Which sectors are money neutral?",
        "options": [
          {
            "text": "Central Government and non-residents",
            "correct": true
          },
          {
            "text": "Households and OFCs",
            "correct": false
          },
          {
            "text": "The Central Bank and ODCs",
            "correct": false
          },
          {
            "text": "NFCs and NPISH",
            "correct": false
          }
        ],
        "explain": "Central Government and non-residents are the money neutral sectors."
      },
      {
        "q": "Broad money is money held by:",
        "options": [
          {
            "text": "The money holding sectors",
            "correct": true
          },
          {
            "text": "The central bank only",
            "correct": false
          },
          {
            "text": "Non-residents only",
            "correct": false
          },
          {
            "text": "General government only",
            "correct": false
          }
        ],
        "explain": "Broad money is defined as money held by the money holding sectors."
      },
      {
        "q": "The monetary base (high-powered money) consists of:",
        "options": [
          {
            "text": "Central bank liabilities — currency in circulation plus reserve deposits at the central bank",
            "correct": true
          },
          {
            "text": "All household savings",
            "correct": false
          },
          {
            "text": "Government tax revenue",
            "correct": false
          },
          {
            "text": "Foreign currency held by exporters",
            "correct": false
          }
        ],
        "explain": "The monetary base is central bank liabilities: currency plus ODC/MHS deposits at the central bank."
      },
      {
        "q": "Net Foreign Assets (NFA) is:",
        "options": [
          {
            "text": "Foreign assets of financial corporations minus their liabilities to the rest of the world",
            "correct": true
          },
          {
            "text": "Total household deposits",
            "correct": false
          },
          {
            "text": "Government securities only",
            "correct": false
          },
          {
            "text": "Bank capital",
            "correct": false
          }
        ],
        "explain": "NFA nets foreign-owned assets against liabilities to the rest of the world."
      },
      {
        "q": "Net Domestic Assets (NDA) represents:",
        "options": [
          {
            "text": "Domestic assets of the financial sector minus its domestic liabilities to the economy",
            "correct": true
          },
          {
            "text": "Foreign reserves only",
            "correct": false
          },
          {
            "text": "The monetary base",
            "correct": false
          },
          {
            "text": "Currency outside banks",
            "correct": false
          }
        ],
        "explain": "NDA is domestic assets minus domestic liabilities — the financial sector's net position on the domestic economy."
      },
      {
        "q": "Net Credit to Government (NCG) is:",
        "options": [
          {
            "text": "Lending to central government (securities and loans) minus government deposits and obligations",
            "correct": true
          },
          {
            "text": "Only treasury bills held by banks",
            "correct": false
          },
          {
            "text": "All taxes collected",
            "correct": false
          },
          {
            "text": "Credit to households",
            "correct": false
          }
        ],
        "explain": "NCG nets lending to central government against government deposits and obligations the financial sector owes."
      },
      {
        "q": "Credit to the private sector covers lending to:",
        "options": [
          {
            "text": "Private companies, households and NPISH",
            "correct": true
          },
          {
            "text": "Central government only",
            "correct": false
          },
          {
            "text": "Foreign banks",
            "correct": false
          },
          {
            "text": "The central bank",
            "correct": false
          }
        ],
        "explain": "Credit to the private sector is lending to private companies, households and NPISH — the most direct measure of support to private activity."
      },
      {
        "q": "Capital, in a monetary survey, refers to:",
        "options": [
          {
            "text": "The financial sector's own funds — equity, retained profits and reserves",
            "correct": true
          },
          {
            "text": "Unclassified balances",
            "correct": false
          },
          {
            "text": "Foreign assets",
            "correct": false
          },
          {
            "text": "Government deposits",
            "correct": false
          }
        ],
        "explain": "Capital is the sector's own funds, representing its financial strength and resilience to shocks."
      },
      {
        "q": "Monetary statistics are presented through:",
        "options": [
          {
            "text": "A series of analytical surveys that combine institutional data into standardised outputs",
            "correct": true
          },
          {
            "text": "A single annual report",
            "correct": false
          },
          {
            "text": "Daily price bulletins",
            "correct": false
          },
          {
            "text": "Company filings",
            "correct": false
          }
        ],
        "explain": "MFS is presented through analytical surveys (Central Bank, ODC, DCS, OFC, FCS)."
      },
      {
        "q": "The headline output of the Central Bank Survey is:",
        "options": [
          {
            "text": "The monetary base",
            "correct": true
          },
          {
            "text": "Broad money",
            "correct": false
          },
          {
            "text": "Non-liquid liabilities",
            "correct": false
          },
          {
            "text": "Treasury bond rates",
            "correct": false
          }
        ],
        "explain": "The Central Bank Survey's headline output is the monetary base."
      },
      {
        "q": "The Depository Corporations Survey (DCS) equals:",
        "options": [
          {
            "text": "Central Bank Survey + ODC Survey",
            "correct": true
          },
          {
            "text": "ODC Survey + OFC Survey",
            "correct": false
          },
          {
            "text": "Central Bank Survey + OFC Survey",
            "correct": false
          },
          {
            "text": "OFC Survey only",
            "correct": false
          }
        ],
        "explain": "DCS = Central Bank Survey + ODC Survey."
      },
      {
        "q": "The DCS is the source of which headline measure?",
        "options": [
          {
            "text": "Broad money",
            "correct": true
          },
          {
            "text": "The reserve requirement ratio",
            "correct": false
          },
          {
            "text": "The repo rate",
            "correct": false
          },
          {
            "text": "Capital",
            "correct": false
          }
        ],
        "explain": "The DCS consolidates the depository sector and is the source of broad money."
      },
      {
        "q": "For an instrument to be included in broad money, its maturity should generally be:",
        "options": [
          {
            "text": "No more than 2 years",
            "correct": true
          },
          {
            "text": "More than 10 years",
            "correct": false
          },
          {
            "text": "Exactly 5 years",
            "correct": false
          },
          {
            "text": "Unlimited",
            "correct": false
          }
        ],
        "explain": "Deposits or close substitutes included in broad money should have a maturity of no more than 2 years."
      },
      {
        "q": "M1, the most liquid measure, is:",
        "options": [
          {
            "text": "Currency outside banks + transferable deposits of MHS",
            "correct": true
          },
          {
            "text": "M2 + foreign currency deposits",
            "correct": false
          },
          {
            "text": "M3 + debt securities",
            "correct": false
          },
          {
            "text": "Currency in circulation only",
            "correct": false
          }
        ],
        "explain": "M1 = currency outside banks + transferable deposits of MHS (current accounts, mobile deposits)."
      },
      {
        "q": "Which measure first adds foreign currency deposits of money holding sectors?",
        "options": [
          {
            "text": "M3",
            "correct": true
          },
          {
            "text": "M1",
            "correct": false
          },
          {
            "text": "M2",
            "correct": false
          },
          {
            "text": "M5",
            "correct": false
          }
        ],
        "explain": "M3 = M2 + foreign currency deposits of MHS."
      },
      {
        "q": "M5 adds which instrument to M4?",
        "options": [
          {
            "text": "Money Market Fund shares/units held by MHS",
            "correct": true
          },
          {
            "text": "Currency outside banks",
            "correct": false
          },
          {
            "text": "Savings deposits",
            "correct": false
          },
          {
            "text": "Foreign currency deposits",
            "correct": false
          }
        ],
        "explain": "M5 = M4 + Money Market Fund shares/units held by MHS."
      },
      {
        "q": "Broad money excludes:",
        "options": [
          {
            "text": "Restricted deposits and fixed deposits over 2 years",
            "correct": true
          },
          {
            "text": "Currency outside banks",
            "correct": false
          },
          {
            "text": "Transferable deposits",
            "correct": false
          },
          {
            "text": "Savings deposits under 2 years",
            "correct": false
          }
        ],
        "explain": "Broad money excludes restricted deposits, fixed deposits over 2 years, and deposits at banks being closed."
      },
      {
        "q": "The OFC Survey covers:",
        "options": [
          {
            "text": "Financial corporations that do not take deposits",
            "correct": true
          },
          {
            "text": "The central bank",
            "correct": false
          },
          {
            "text": "Commercial banks",
            "correct": false
          },
          {
            "text": "General government",
            "correct": false
          }
        ],
        "explain": "The OFC Survey covers non-deposit-takers — insurance, pension funds, credit-only MFIs and forex bureaus."
      },
      {
        "q": "Most OFC liabilities are classified as non-liquid because:",
        "options": [
          {
            "text": "OFCs do not take deposits, so their obligations are not part of broad money",
            "correct": true
          },
          {
            "text": "OFCs are unregulated",
            "correct": false
          },
          {
            "text": "OFCs hold no assets",
            "correct": false
          },
          {
            "text": "OFCs deal only with non-residents",
            "correct": false
          }
        ],
        "explain": "As non-deposit-takers, OFC liabilities (insurance, pensions) are non-liquid and outside broad money."
      },
      {
        "q": "The Financial Corporations Survey (FCS) equals:",
        "options": [
          {
            "text": "Depository Corporations Survey + OFC Survey",
            "correct": true
          },
          {
            "text": "Central Bank Survey + ODC Survey",
            "correct": false
          },
          {
            "text": "ODC Survey + OFC Survey",
            "correct": false
          },
          {
            "text": "Central Bank Survey only",
            "correct": false
          }
        ],
        "explain": "FCS = Depository Corporations Survey + OFC Survey — the whole financial sector consolidated."
      },
      {
        "q": "On any survey, capital and other items net should be:",
        "options": [
          {
            "text": "Reported as two separate line items",
            "correct": true
          },
          {
            "text": "Merged into one figure",
            "correct": false
          },
          {
            "text": "Excluded",
            "correct": false
          },
          {
            "text": "Added to NFA",
            "correct": false
          }
        ],
        "explain": "Capital (own funds) and other items net (unclassified balances and adjustments) are distinct and reported separately."
      },
      {
        "q": "Other Items Net records:",
        "options": [
          {
            "text": "Unclassified assets minus unclassified liabilities, plus consolidation adjustments",
            "correct": true
          },
          {
            "text": "Only treasury bills",
            "correct": false
          },
          {
            "text": "Total deposits",
            "correct": false
          },
          {
            "text": "Foreign reserves",
            "correct": false
          }
        ],
        "explain": "Other Items Net is unclassified assets minus unclassified liabilities, plus consolidation adjustments."
      },
      {
        "q": "The FCS provides:",
        "options": [
          {
            "text": "The most complete view of the financial sector's claims and liabilities",
            "correct": true
          },
          {
            "text": "Only the central bank's balance sheet",
            "correct": false
          },
          {
            "text": "Only household data",
            "correct": false
          },
          {
            "text": "Only interest rates",
            "correct": false
          }
        ],
        "explain": "The FCS consolidates the whole financial sector — the most complete view of its claims and liabilities."
      },
      {
        "q": "Liquid liabilities on a survey are:",
        "options": [
          {
            "text": "Deposit and deposit-substitute liabilities that form part of broad money",
            "correct": true
          },
          {
            "text": "Long-term insurance reserves",
            "correct": false
          },
          {
            "text": "Capital",
            "correct": false
          },
          {
            "text": "Foreign assets",
            "correct": false
          }
        ],
        "explain": "Liquid liabilities are the deposit-type liabilities that form part of broad money."
      },
      {
        "q": "Which survey's headline output is broad money?",
        "options": [
          {
            "text": "The Depository Corporations Survey",
            "correct": true
          },
          {
            "text": "The OFC Survey",
            "correct": false
          },
          {
            "text": "The Central Bank Survey",
            "correct": false
          },
          {
            "text": "The interest-rate report",
            "correct": false
          }
        ],
        "explain": "The Depository Corporations Survey is the source of broad money."
      },
      {
        "q": "The Central Bank rate primarily signals:",
        "options": [
          {
            "text": "The monetary policy direction of the central bank",
            "correct": true
          },
          {
            "text": "The exchange rate",
            "correct": false
          },
          {
            "text": "Bank profits",
            "correct": false
          },
          {
            "text": "The price of treasury bills",
            "correct": false
          }
        ],
        "explain": "The central bank rate indicates the policy stance — up to cool inflation, down to support growth."
      },
      {
        "q": "The interbank rate is the rate at which:",
        "options": [
          {
            "text": "ODCs lend to each other for very short periods",
            "correct": true
          },
          {
            "text": "The central bank lends to government",
            "correct": false
          },
          {
            "text": "Households borrow mortgages",
            "correct": false
          },
          {
            "text": "Treasury bonds are issued",
            "correct": false
          }
        ],
        "explain": "The interbank rate is what ODCs charge each other, usually overnight to 7 days, to cover temporary cash shortages."
      },
      {
        "q": "The reserve requirement ratio is:",
        "options": [
          {
            "text": "The share of banks' deposit liabilities that must be held at the central bank",
            "correct": true
          },
          {
            "text": "The tax rate on banks",
            "correct": false
          },
          {
            "text": "The interest on savings",
            "correct": false
          },
          {
            "text": "The treasury bill rate",
            "correct": false
          }
        ],
        "explain": "It is the proportion of deposit liabilities banks must keep at the central bank; a higher ratio constrains lending."
      },
      {
        "q": "Treasury bill rates apply to instruments with maturities of:",
        "options": [
          {
            "text": "Up to one year (e.g. 91, 182, 364 days)",
            "correct": true
          },
          {
            "text": "More than ten years",
            "correct": false
          },
          {
            "text": "Exactly five years",
            "correct": false
          },
          {
            "text": "No fixed maturity",
            "correct": false
          }
        ],
        "explain": "Treasury bills are short-term — up to one year (91, 182 and 364 days). Bonds are over a year."
      },
      {
        "q": "Lending by economic activity classifies credit by:",
        "options": [
          {
            "text": "The industry/economic activity of the borrower",
            "correct": true
          },
          {
            "text": "The size of the loan",
            "correct": false
          },
          {
            "text": "The loan's currency",
            "correct": false
          },
          {
            "text": "The borrower's age",
            "correct": false
          }
        ],
        "explain": "It groups lending by the borrower's economic activity, following the standard industrial classification."
      },
      {
        "q": "Under the activity classification, breeding animals and growing crops fall under:",
        "options": [
          {
            "text": "Agriculture, forestry and fishing",
            "correct": true
          },
          {
            "text": "Manufacturing",
            "correct": false
          },
          {
            "text": "Mining and quarrying",
            "correct": false
          },
          {
            "text": "Construction",
            "correct": false
          }
        ],
        "explain": "Growing crops, raising animals, forestry and fishing fall under Agriculture, forestry and fishing."
      },
      {
        "q": "The transformation of raw materials into new products is classified as:",
        "options": [
          {
            "text": "Manufacturing",
            "correct": true
          },
          {
            "text": "Wholesale and retail trade",
            "correct": false
          },
          {
            "text": "Construction",
            "correct": false
          },
          {
            "text": "Mining and quarrying",
            "correct": false
          }
        ],
        "explain": "Manufacturing is the physical or chemical transformation of materials into new products."
      }
    ]
  },
  "7": {
    "pass_mark": 75,
    "ask": 20,
    "title": "Final Assessment",
    "intro": "This assessment has 37 questions in its bank; you will be asked a randomly selected 20. The question order and the answer options are shuffled on every attempt, so a retake will mix in new questions. You need 75% to pass and earn your certificate.",
    "questions": [
      {
        "q": "Which three interlinked elements make up the external accounts?",
        "options": [
          {
            "text": "The BOP, the IIP, and the other changes in financial assets and liabilities accounts",
            "correct": true
          },
          {
            "text": "Current, capital and financial accounts only",
            "correct": false
          },
          {
            "text": "Exports, imports and reserves",
            "correct": false
          },
          {
            "text": "Households, corporations and government",
            "correct": false
          }
        ],
        "explain": "The external accounts comprise the BOP, the IIP, and the other changes in financial assets and liabilities accounts."
      },
      {
        "q": "What is the current standard manual for compiling BOP and IIP statistics, and when was it released?",
        "options": [
          {
            "text": "BPM6, released in 2009",
            "correct": false
          },
          {
            "text": "BPM7, released by the IMF in March 2025",
            "correct": true
          },
          {
            "text": "SNA 2025, released in 2025",
            "correct": false
          },
          {
            "text": "BPM5, released in 1993",
            "correct": false
          }
        ],
        "explain": "BPM7 is the current standard, released by the IMF in March 2025 and aligned with SNA 2025."
      },
      {
        "q": "Which statement best defines the Balance of Payments?",
        "options": [
          {
            "text": "A stock statement of assets and liabilities at a point in time",
            "correct": false
          },
          {
            "text": "A record of flows between residents and the rest of the world over a period",
            "correct": true
          },
          {
            "text": "A list of a country's reserve assets",
            "correct": false
          },
          {
            "text": "A government budget statement",
            "correct": false
          }
        ],
        "explain": "The BOP records flows — transactions and other flows — between residents and nonresidents over a period."
      },
      {
        "q": "In the external accounts, the terms used for transactions in financial assets and liabilities are:",
        "options": [
          {
            "text": "Credit and debit",
            "correct": false
          },
          {
            "text": "NAFA and NIL",
            "correct": true
          },
          {
            "text": "Surplus and deficit",
            "correct": false
          },
          {
            "text": "Stock and flow",
            "correct": false
          }
        ],
        "explain": "NAFA (net acquisition of financial assets) and NIL (net incurrence of liabilities) are used for financial transactions."
      },
      {
        "q": "Which accounting basis does the integrated framework of the SNA and external accounts favour?",
        "options": [
          {
            "text": "Cash basis",
            "correct": false
          },
          {
            "text": "Accrual basis",
            "correct": true
          },
          {
            "text": "Modified cash basis",
            "correct": false
          },
          {
            "text": "Commitment basis",
            "correct": false
          }
        ],
        "explain": "The integrated framework favours accrual accounting, recording flows when economic value is created, transformed, exchanged, transferred or extinguished."
      },
      {
        "q": "Which is the basis for valuing transactions in the external accounts?",
        "options": [
          {
            "text": "Historical cost",
            "correct": false
          },
          {
            "text": "Exchange (market) prices",
            "correct": true
          },
          {
            "text": "Customs tariff value",
            "correct": false
          },
          {
            "text": "Book value",
            "correct": false
          }
        ],
        "explain": "Exchange (market) prices are the basis for valuation in the external accounts."
      },
      {
        "q": "Residence of an institutional unit is determined by its:",
        "options": [
          {
            "text": "Nationality of owners",
            "correct": false
          },
          {
            "text": "Centre of predominant economic interest",
            "correct": true
          },
          {
            "text": "Place of incorporation only",
            "correct": false
          },
          {
            "text": "Currency used",
            "correct": false
          }
        ],
        "explain": "Residence is the economic territory with which a unit has its strongest connection — its centre of predominant economic interest."
      },
      {
        "q": "Which of the following is NOT one of the eight data-quality criteria for ESS?",
        "options": [
          {
            "text": "Relevance",
            "correct": false
          },
          {
            "text": "Timeliness",
            "correct": false
          },
          {
            "text": "Profitability",
            "correct": true
          },
          {
            "text": "Coverage",
            "correct": false
          }
        ],
        "explain": "The eight criteria are relevance; accuracy & reliability; timeliness; consistency & comparability; accessibility & cost; coverage; stability & continuity; and confidentiality & legal compliance. Profitability is not among them."
      },
      {
        "q": "The current account comprises which three sub-accounts?",
        "options": [
          {
            "text": "Goods and services; earned income; transfer income",
            "correct": true
          },
          {
            "text": "Direct, portfolio and other investment",
            "correct": false
          },
          {
            "text": "Current, capital and financial",
            "correct": false
          },
          {
            "text": "Assets, liabilities and net worth",
            "correct": false
          }
        ],
        "explain": "The current account comprises goods and services, earned income (formerly primary income) and transfer income (formerly secondary income)."
      },
      {
        "q": "What is the primary data source for compiling general merchandise?",
        "options": [
          {
            "text": "Stock-exchange records",
            "correct": false
          },
          {
            "text": "International Merchandise Trade Statistics (IMTS)",
            "correct": true
          },
          {
            "text": "Pension-fund reports",
            "correct": false
          },
          {
            "text": "Central-bank reserve records",
            "correct": false
          }
        ],
        "explain": "IMTS — primarily customs records — are the main source for general merchandise."
      },
      {
        "q": "Merchanting is recorded in the BOP of:",
        "options": [
          {
            "text": "The producing economy",
            "correct": false
          },
          {
            "text": "The merchant's economy of residence",
            "correct": true
          },
          {
            "text": "The final buyer's economy",
            "correct": false
          },
          {
            "text": "Each economy equally",
            "correct": false
          }
        ],
        "explain": "Merchanting is recorded only in the merchant's economy; the acquisition is a negative export and the sale a positive export there."
      },
      {
        "q": "In a processing arrangement where the principal owns the material inputs, the processor's fee is recorded under:",
        "options": [
          {
            "text": "General merchandise",
            "correct": false
          },
          {
            "text": "Manufacturing services",
            "correct": true
          },
          {
            "text": "Reserve assets",
            "correct": false
          },
          {
            "text": "Capital transfers",
            "correct": false
          }
        ],
        "explain": "Because ownership of the goods does not change, only the processing fee is recorded — under manufacturing services."
      },
      {
        "q": "How many standard service categories does BPM7 have?",
        "options": [
          {
            "text": "10",
            "correct": false
          },
          {
            "text": "12",
            "correct": false
          },
          {
            "text": "17",
            "correct": true
          },
          {
            "text": "5",
            "correct": false
          }
        ],
        "explain": "BPM7 has 17 first-level service categories — five more than BPM6."
      },
      {
        "q": "Which GATS mode of supply is NOT part of the BOP services account?",
        "options": [
          {
            "text": "Mode 1 — cross-border supply",
            "correct": false
          },
          {
            "text": "Mode 2 — consumption abroad",
            "correct": false
          },
          {
            "text": "Mode 3 — commercial presence",
            "correct": true
          },
          {
            "text": "Mode 4 — presence of natural persons",
            "correct": false
          }
        ],
        "explain": "Mode 3 (resident-to-resident sales through a local affiliate of a nonresident) is not part of the services account."
      },
      {
        "q": "The BPM7 term 'earned income' replaces which BPM6 term?",
        "options": [
          {
            "text": "Secondary income",
            "correct": false
          },
          {
            "text": "Primary income",
            "correct": true
          },
          {
            "text": "Current transfers",
            "correct": false
          },
          {
            "text": "Capital transfers",
            "correct": false
          }
        ],
        "explain": "'Earned income' replaces 'primary income', harmonising with SNA 2025."
      },
      {
        "q": "A one-way provision of value with no return expected is a(n):",
        "options": [
          {
            "text": "Exchange",
            "correct": false
          },
          {
            "text": "Transfer",
            "correct": true
          },
          {
            "text": "Reserve",
            "correct": false
          },
          {
            "text": "Derivative",
            "correct": false
          }
        ],
        "explain": "A transfer is a one-way provision without a direct return; an exchange involves a mutual provision of economic value."
      },
      {
        "q": "Is informal cross-border trade (ICBT) in goods included in merchandise trade data?",
        "options": [
          {
            "text": "No, it is always excluded",
            "correct": false
          },
          {
            "text": "Yes, and data collection at border stations is encouraged",
            "correct": true
          },
          {
            "text": "Only if above a value threshold",
            "correct": false
          },
          {
            "text": "Only for services",
            "correct": false
          }
        ],
        "explain": "Yes — ICBT is included, and border-station data collection is encouraged to capture it."
      },
      {
        "q": "A current-account surplus occurs when:",
        "options": [
          {
            "text": "Debits exceed credits",
            "correct": false
          },
          {
            "text": "Credits (exports and income receivable) exceed debits",
            "correct": true
          },
          {
            "text": "The capital account is negative",
            "correct": false
          },
          {
            "text": "Reserves fall",
            "correct": false
          }
        ],
        "explain": "A surplus arises when credits exceed debits — the country earns more abroad than it spends."
      },
      {
        "q": "Which is the full definition of a capital transfer?",
        "options": [
          {
            "text": "A recurring payment for services rendered",
            "correct": false
          },
          {
            "text": "A one-time, unrequited transaction relating to the acquisition, disposal or forgiveness of assets or liabilities",
            "correct": true
          },
          {
            "text": "Any transfer made in cash",
            "correct": false
          },
          {
            "text": "A loan between residents and nonresidents",
            "correct": false
          }
        ],
        "explain": "A capital transfer is a one-time, unrequited transaction relating to the acquisition, disposal or forgiveness of assets or liabilities."
      },
      {
        "q": "Which condition would classify a transfer as a capital transfer?",
        "options": [
          {
            "text": "It is made every month",
            "correct": false
          },
          {
            "text": "A liability is forgiven by the creditor",
            "correct": true
          },
          {
            "text": "It pays for imported goods",
            "correct": false
          },
          {
            "text": "It is a wage payment",
            "correct": false
          }
        ],
        "explain": "Forgiveness of a liability by the creditor is one of the three conditions for a capital transfer."
      },
      {
        "q": "Which of the following is a nonproduced nonfinancial asset?",
        "options": [
          {
            "text": "A corporate bond",
            "correct": false
          },
          {
            "text": "Mineral rights",
            "correct": true
          },
          {
            "text": "A bank deposit",
            "correct": false
          },
          {
            "text": "An investment fund share",
            "correct": false
          }
        ],
        "explain": "Natural resources such as land, mineral rights and sport players are nonproduced nonfinancial assets."
      },
      {
        "q": "An irregular tax on inheritances and the value of assets is classified as:",
        "options": [
          {
            "text": "A current transfer",
            "correct": false
          },
          {
            "text": "A capital tax (a capital transfer)",
            "correct": true
          },
          {
            "text": "Earned income",
            "correct": false
          },
          {
            "text": "A reserve asset",
            "correct": false
          }
        ],
        "explain": "Capital taxes — including inheritances, gifts and legacies — are capital transfers, not ongoing tax revenue."
      },
      {
        "q": "Large, nonrecurring insurance payouts after a catastrophe may be recorded as:",
        "options": [
          {
            "text": "Current transfers always",
            "correct": false
          },
          {
            "text": "Capital transfers if exceptionally large and infrequent",
            "correct": true
          },
          {
            "text": "Reserve assets",
            "correct": false
          },
          {
            "text": "Direct investment",
            "correct": false
          }
        ],
        "explain": "Exceptional nonlife insurance claims, if exceptionally large and infrequent, may be recorded as capital transfers."
      },
      {
        "q": "Current-account balance + capital-account balance equals:",
        "options": [
          {
            "text": "Gross domestic product",
            "correct": false
          },
          {
            "text": "Net lending (surplus) / net borrowing (deficit)",
            "correct": true
          },
          {
            "text": "The statistical discrepancy",
            "correct": false
          },
          {
            "text": "Total reserves",
            "correct": false
          }
        ],
        "explain": "Their sum is net lending or net borrowing, which the financial account finances."
      },
      {
        "q": "The financial account is classified along which four dimensions?",
        "options": [
          {
            "text": "Functional categories, instruments, institutional sectors, maturity",
            "correct": true
          },
          {
            "text": "Goods, services, income, transfers",
            "correct": false
          },
          {
            "text": "Assets, liabilities, equity, reserves",
            "correct": false
          },
          {
            "text": "Cash, accrual, market, book",
            "correct": false
          }
        ],
        "explain": "It is classified by functional category, financial instrument, institutional sector, and maturity."
      },
      {
        "q": "A direct-investment relationship is typically evidenced by ownership of:",
        "options": [
          {
            "text": "1% or more of voting power",
            "correct": false
          },
          {
            "text": "10% or more of voting power",
            "correct": true
          },
          {
            "text": "50% or more of voting power",
            "correct": false
          },
          {
            "text": "100% of voting power",
            "correct": false
          }
        ],
        "explain": "Direct investment is typically evidenced at 10% or more of voting power."
      },
      {
        "q": "The key feature of securities under portfolio investment is their:",
        "options": [
          {
            "text": "Negotiability",
            "correct": true
          },
          {
            "text": "Long maturity",
            "correct": false
          },
          {
            "text": "Government backing",
            "correct": false
          },
          {
            "text": "Physical form",
            "correct": false
          }
        ],
        "explain": "Negotiability — the ability to be traded in financial markets — is the key feature of portfolio-investment securities."
      },
      {
        "q": "On financial derivatives, gains and losses are recorded as:",
        "options": [
          {
            "text": "Interest income",
            "correct": false
          },
          {
            "text": "Dividends",
            "correct": false
          },
          {
            "text": "Revaluations in the other changes account",
            "correct": true
          },
          {
            "text": "Capital transfers",
            "correct": false
          }
        ],
        "explain": "No income accrues on derivatives; gains and losses are revaluations in the other changes in financial assets and liabilities account."
      },
      {
        "q": "Which functional category may be held only by the monetary authorities?",
        "options": [
          {
            "text": "Portfolio investment",
            "correct": false
          },
          {
            "text": "Direct investment",
            "correct": false
          },
          {
            "text": "Reserve assets",
            "correct": true
          },
          {
            "text": "Other investment",
            "correct": false
          }
        ],
        "explain": "Reserve assets are external assets readily available to and controlled by the monetary authorities."
      },
      {
        "q": "An investor buys units in a cross-border money-market fund. This is recorded as:",
        "options": [
          {
            "text": "Direct investment",
            "correct": false
          },
          {
            "text": "Portfolio investment",
            "correct": true
          },
          {
            "text": "A reserve asset",
            "correct": false
          },
          {
            "text": "A capital transfer",
            "correct": false
          }
        ],
        "explain": "Investment fund shares in the form of securities are portfolio investment, regardless of the size of the holding."
      },
      {
        "q": "Short-term debt has an original maturity of:",
        "options": [
          {
            "text": "One year or less",
            "correct": true
          },
          {
            "text": "Two years or less",
            "correct": false
          },
          {
            "text": "Three years or less",
            "correct": false
          },
          {
            "text": "Five years or less",
            "correct": false
          }
        ],
        "explain": "Short-term debt has an original maturity of one year or less."
      },
      {
        "q": "The IIP is best described as:",
        "options": [
          {
            "text": "A flow statement over a period",
            "correct": false
          },
          {
            "text": "A position (stock) statement of external assets and liabilities at a point in time",
            "correct": true
          },
          {
            "text": "A record of customs transactions",
            "correct": false
          },
          {
            "text": "A government budget",
            "correct": false
          }
        ],
        "explain": "The IIP shows the value and composition of external financial assets and liabilities at a point in time."
      },
      {
        "q": "A negative net IIP indicates that the country is a:",
        "options": [
          {
            "text": "Net creditor",
            "correct": false
          },
          {
            "text": "Net debtor",
            "correct": true
          },
          {
            "text": "Reserve issuer",
            "correct": false
          },
          {
            "text": "Surplus economy",
            "correct": false
          }
        ],
        "explain": "A negative net IIP (liabilities exceed assets) means the country is a net debtor."
      },
      {
        "q": "Which is one of the five IIP classification dimensions?",
        "options": [
          {
            "text": "Tax bracket",
            "correct": false
          },
          {
            "text": "Currency of denomination",
            "correct": true
          },
          {
            "text": "Customs tariff line",
            "correct": false
          },
          {
            "text": "Industry of importer",
            "correct": false
          }
        ],
        "explain": "The five dimensions are functional category, financial instrument, institutional sector, maturity and currency."
      },
      {
        "q": "In the integrated IIP, debt write-offs and reclassifications are recorded as:",
        "options": [
          {
            "text": "Financial-account transactions",
            "correct": false
          },
          {
            "text": "Revaluations",
            "correct": false
          },
          {
            "text": "Other volume changes",
            "correct": true
          },
          {
            "text": "Current transfers",
            "correct": false
          }
        ],
        "explain": "Write-offs and reclassifications are other volume changes; revaluations are exchange-rate and market-price changes."
      },
      {
        "q": "When assessing sustainability, a large negative net IIP as a share of GDP:",
        "options": [
          {
            "text": "Always indicates a surplus economy",
            "correct": false
          },
          {
            "text": "May raise risks",
            "correct": true
          },
          {
            "text": "Has no meaning",
            "correct": false
          },
          {
            "text": "Equals a balanced position",
            "correct": false
          }
        ],
        "explain": "A large negative net IIP/GDP may raise sustainability risks; a positive ratio suggests a surplus economy."
      },
      {
        "q": "How does the IIP relate to the BOP?",
        "options": [
          {
            "text": "It records the same flows",
            "correct": false
          },
          {
            "text": "It shows the stock/position while the BOP records the flows",
            "correct": true
          },
          {
            "text": "It replaces the BOP",
            "correct": false
          },
          {
            "text": "It covers only reserves",
            "correct": false
          }
        ],
        "explain": "The IIP is the stock/position statement; the BOP records the flows over time."
      }
    ]
  },
  "6": {
    "pass_mark": 75,
    "title": "Final Assessment",
    "intro": "This assessment covers all six modules. Choose the single best answer for each question. You need {pass}% to pass and receive your certificate. Questions and options are shuffled, and you can retake the test if needed.",
    "questions": [
      {
        "module": 1,
        "q": "Which two frameworks are most commonly used to define and measure poverty?",
        "options": [
          {
            "text": "Monetary and multidimensional",
            "correct": true
          },
          {
            "text": "Absolute and subjective",
            "correct": false
          },
          {
            "text": "Chronic and transient",
            "correct": false
          },
          {
            "text": "Income and inequality",
            "correct": false
          }
        ],
        "explain": "The two dominant frameworks are monetary (income/consumption vs a line) and multidimensional (deprivations across dimensions). [Module 1]"
      },
      {
        "module": 1,
        "q": "A threshold fixed to the cost of basic human needs, used mainly in low- and middle-income countries, describes:",
        "options": [
          {
            "text": "Absolute poverty",
            "correct": true
          },
          {
            "text": "Relative poverty",
            "correct": false
          },
          {
            "text": "Subjective poverty",
            "correct": false
          },
          {
            "text": "Vulnerability",
            "correct": false
          }
        ],
        "explain": "Absolute poverty uses a fixed minimum-needs threshold; relative poverty is defined against society's average. [Module 1]"
      },
      {
        "module": 1,
        "q": "A household that is poor for many years due to structural factors such as lack of education and long-term illness is experiencing:",
        "options": [
          {
            "text": "Chronic poverty",
            "correct": true
          },
          {
            "text": "Transient poverty",
            "correct": false
          },
          {
            "text": "Relative poverty",
            "correct": false
          },
          {
            "text": "Subjective poverty",
            "correct": false
          }
        ],
        "explain": "Chronic poverty is long-term and structural; transient poverty is short-term and shock-driven. [Module 1]"
      },
      {
        "module": 2,
        "q": "Across the EAC Partner States, the welfare measure used for monetary poverty is:",
        "options": [
          {
            "text": "Consumption",
            "correct": true
          },
          {
            "text": "Income",
            "correct": false
          },
          {
            "text": "Self-reported wealth",
            "correct": false
          },
          {
            "text": "Tax records",
            "correct": false
          }
        ],
        "explain": "All EAC Partner States use consumption, which is a better proxy than income in largely informal economies. [Module 2]"
      },
      {
        "module": 2,
        "q": "How does a durable good (e.g. a refrigerator) enter the consumption aggregate?",
        "options": [
          {
            "text": "As the annual value of use (service flow), via the user-cost method",
            "correct": true
          },
          {
            "text": "As its full purchase price in the year it was bought",
            "correct": false
          },
          {
            "text": "As its current resale value",
            "correct": false
          },
          {
            "text": "It is always excluded",
            "correct": false
          }
        ],
        "explain": "Durables enter as a service flow over their life (user-cost), not as a lump-sum purchase. [Module 2]"
      },
      {
        "module": 2,
        "q": "A household of 2 adults and 3 children consumes $10,000. Using the modified OECD scale (1.0 + 0.7 + 3×0.3 = 2.6), consumption per adult equivalent is:",
        "options": [
          {
            "text": "$3,846",
            "correct": true
          },
          {
            "text": "$2,000",
            "correct": false
          },
          {
            "text": "$5,000",
            "correct": false
          },
          {
            "text": "$10,000",
            "correct": false
          }
        ],
        "explain": "$10,000 ÷ 2.6 = $3,846 (vs $2,000 per capita). The scale changes the figure. [Module 2]"
      },
      {
        "module": 2,
        "q": "Why is rent imputed for owner-occupied homes when building the consumption aggregate?",
        "options": [
          {
            "text": "So owners are comparable to renters and their housing welfare isn't understated",
            "correct": true
          },
          {
            "text": "To tax homeowners",
            "correct": false
          },
          {
            "text": "Because owners always pay more than renters",
            "correct": false
          },
          {
            "text": "To remove housing from the aggregate",
            "correct": false
          }
        ],
        "explain": "Owners consume housing services too; imputing rent keeps them comparable to renters. [Module 2]"
      },
      {
        "module": 3,
        "q": "The World Bank's current international extreme-poverty line (2021 PPP) is:",
        "options": [
          {
            "text": "$3.00 per person per day",
            "correct": true
          },
          {
            "text": "$1.90 per person per day",
            "correct": false
          },
          {
            "text": "$2.15 per person per day",
            "correct": false
          },
          {
            "text": "$8.30 per person per day",
            "correct": false
          }
        ],
        "explain": "$3.00 (2021 PPP) is current; $1.90 and $2.15 are older vintages; $8.30 is the upper-middle-income line. [Module 3]"
      },
      {
        "module": 3,
        "q": "Under the Cost of Basic Needs approach, if the food line z_F = 1,500 and the non-food line z_NF = 587.3, the total absolute poverty line is:",
        "options": [
          {
            "text": "2,087.3",
            "correct": true
          },
          {
            "text": "912.7",
            "correct": false
          },
          {
            "text": "1,500",
            "correct": false
          },
          {
            "text": "587.3",
            "correct": false
          }
        ],
        "explain": "z_CBN = z_F + z_NF = 1,500 + 587.3 = 2,087.3. [Module 3]"
      },
      {
        "module": 3,
        "q": "The International Poverty Line is computed as the ___ of the PPP-converted national lines of the world's poorest countries.",
        "options": [
          {
            "text": "Median",
            "correct": true
          },
          {
            "text": "Maximum",
            "correct": false
          },
          {
            "text": "Sum",
            "correct": false
          },
          {
            "text": "Mode",
            "correct": false
          }
        ],
        "explain": "The IPL is the median of the poorest countries' PPP-converted national lines. [Module 3]"
      },
      {
        "module": 3,
        "q": "The current World Bank line for lower-middle-income countries (2021 PPP) is:",
        "options": [
          {
            "text": "$4.20 per person per day",
            "correct": true
          },
          {
            "text": "$3.65 per person per day",
            "correct": false
          },
          {
            "text": "$3.00 per person per day",
            "correct": false
          },
          {
            "text": "$8.30 per person per day",
            "correct": false
          }
        ],
        "explain": "In 2021 PPP the lower-middle-income line is $4.20 ($3.65 was the older 2017-PPP figure). [Module 3]"
      },
      {
        "module": 4,
        "q": "In the FGT formula, which value of the parameter α gives the headcount ratio (P₀)?",
        "options": [
          {
            "text": "α = 0",
            "correct": true
          },
          {
            "text": "α = 1",
            "correct": false
          },
          {
            "text": "α = 2",
            "correct": false
          },
          {
            "text": "α = 10",
            "correct": false
          }
        ],
        "explain": "α = 0 → P₀ (headcount); α = 1 → P₁ (gap); α = 2 → P₂ (squared gap). [Module 4]"
      },
      {
        "module": 4,
        "q": "Which indicator is most useful for estimating the minimum budget needed to lift everyone to the poverty line (with perfect targeting)?",
        "options": [
          {
            "text": "The poverty gap index (P₁)",
            "correct": true
          },
          {
            "text": "The headcount ratio (P₀)",
            "correct": false
          },
          {
            "text": "The squared poverty gap (P₂)",
            "correct": false
          },
          {
            "text": "The Gini index",
            "correct": false
          }
        ],
        "explain": "The sum of poverty gaps is the minimum cost of eliminating poverty under perfect targeting — P₁ is the budgeting indicator. [Module 4]"
      },
      {
        "module": 4,
        "q": "A Gini index of 0 represents:",
        "options": [
          {
            "text": "Perfect equality",
            "correct": true
          },
          {
            "text": "Perfect inequality",
            "correct": false
          },
          {
            "text": "That everyone is poor",
            "correct": false
          },
          {
            "text": "A poverty line of zero",
            "correct": false
          }
        ],
        "explain": "Gini ranges 0 (perfect equality) to 100 (perfect inequality). [Module 4]"
      },
      {
        "module": 5,
        "q": "In a multidimensional poverty index, if the incidence H = 40% and the intensity A = 50%, the adjusted headcount ratio M₀ is:",
        "options": [
          {
            "text": "0.20",
            "correct": true
          },
          {
            "text": "0.40",
            "correct": false
          },
          {
            "text": "0.50",
            "correct": false
          },
          {
            "text": "0.90",
            "correct": false
          }
        ],
        "explain": "M₀ = H × A = 0.40 × 0.50 = 0.20. [Module 5]"
      },
      {
        "module": 5,
        "q": "In the global MPI, a person is identified as multidimensionally poor if deprived in:",
        "options": [
          {
            "text": "At least one-third of the weighted indicators",
            "correct": true
          },
          {
            "text": "All of the indicators",
            "correct": false
          },
          {
            "text": "Any single indicator",
            "correct": false
          },
          {
            "text": "Exactly half of the indicators",
            "correct": false
          }
        ],
        "explain": "The dual-cutoff rule: poor if deprived in ≥ one-third of the weighted indicators. [Module 5]"
      },
      {
        "module": 5,
        "q": "Which statement about comparability of multidimensional poverty indices is correct?",
        "options": [
          {
            "text": "The EAC regional MPI is comparable across Partner States; most national MPIs are not comparable across countries",
            "correct": true
          },
          {
            "text": "All national MPIs are directly comparable across countries",
            "correct": false
          },
          {
            "text": "No MPI can ever be compared across countries",
            "correct": false
          },
          {
            "text": "The global MPI cannot be compared across countries",
            "correct": false
          }
        ],
        "explain": "Standardised measures (global, EAC regional) are comparable; bespoke national MPIs generally are not. [Module 5]"
      },
      {
        "module": 6,
        "q": "Why is fieldwork for an IHBS/HBS spread over a full 12 months?",
        "options": [
          {
            "text": "To capture seasonal variation in consumption and prices",
            "correct": true
          },
          {
            "text": "To reduce the cost of the survey",
            "correct": false
          },
          {
            "text": "Because enumerators work slowly",
            "correct": false
          },
          {
            "text": "To avoid using a sampling frame",
            "correct": false
          }
        ],
        "explain": "A 12-month window captures seasonality so the data represents the whole year. [Module 6]"
      },
      {
        "module": 6,
        "q": "For collecting food consumption data in most poverty surveys, the preferred method is:",
        "options": [
          {
            "text": "A 7-day recall with a detailed food list",
            "correct": true
          },
          {
            "text": "A 12-month diary",
            "correct": false
          },
          {
            "text": "A single yes/no question",
            "correct": false
          },
          {
            "text": "A telephone interview (CATI)",
            "correct": false
          }
        ],
        "explain": "A 7-day recall balances accuracy and cost and is preferred for food consumption. [Module 6]"
      },
      {
        "module": 6,
        "q": "Computer-assisted personal interviewing (CAPI) is generally preferred over paper (PAPI) because it:",
        "options": [
          {
            "text": "Enables real-time validity checks and faster, higher-quality data",
            "correct": true
          },
          {
            "text": "Removes the need for enumerators",
            "correct": false
          },
          {
            "text": "Is always the cheapest option",
            "correct": false
          },
          {
            "text": "Avoids the need for a questionnaire",
            "correct": false
          }
        ],
        "explain": "CAPI builds checks and skip patterns into the interview, speeding collection and improving quality. [Module 6]"
      }
    ]
  }
}
JSON
, true, 512, JSON_THROW_ON_ERROR);
