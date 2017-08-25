### BOB 项目 ###
### Step 1 : 检查sku唯一
# 主表： note, nid 即 entity_id, bundle='bob_product'
# SKU : field_data_field_sku  [select entity_id, field_sku_value from field_data_field_sku ]

### Step 2 : 修改表字段
SKU : field_data_field_sku
altnames : field_data_field_altnames
antigen protein : field_data_field_antigen_protein
size: field_data_field_size
size unit : field_data_field_size_unit

#=================================================================================
## Product Name : node.title where nid = xxx
参数配置： 
Product Name
2
node
title

## ALTnames 修改： 
参数配置：
ALTnames
25
field_data_field_altnames
field_altnames_value


## Product Type 修改 ：
参数配置：
Product Type 2
11
field_data_field_product_type
field_product_type_tid
#=================================================================================
字段映射 ： 
	sites/all/modules/features/bob_product/bob_product.feeds_importer_default.inc
        'mappings' => array(
          0 => array(
            'source' => 'BON Cat Number',
            'target' => 'guid',
            'unique' => 1,
          ),
          1 => array(
            'source' => 'Product Name',
            'target' => 'title',
            'unique' => FALSE,
          ),
          2 => array(
            'source' => 'BON Cat Number',
            'target' => 'field_product:sku',
            'unique' => FALSE,
          ),
          3 => array(
            'source' => 'Product Description',
            'target' => 'body',
            'unique' => FALSE,
          ),
          4 => array(
            'source' => 'Product Type 2',
            'target' => 'field_product_type',
            'unique' => FALSE,
          ),
          5 => array(
            'source' => 'Antigen Protein',
            'target' => 'field_antigen_protein',
            'unique' => FALSE,
          ),
          6 => array(
            'source' => 'Antigen Protein ID',
            'target' => 'field_antigen_protein_id',
            'unique' => FALSE,
          ),
          7 => array(
            'source' => 'Immunogen',
            'target' => 'field_immunogen',
            'unique' => FALSE,
          ),
		  8 => array(
            'source' => 'Host Species',
            'target' => 'field_host_species',
            'unique' => FALSE,
          ),
          9 => array(
            'source' => 'Clonality',
            'target' => 'field_clonality',
            'unique' => FALSE,
          ),
          10 => array(
            'source' => 'Conjugation',
            'target' => 'field_conjugation',
            'unique' => FALSE,
          ),
          11 => array(
            'source' => 'Antigen Modification',
            'target' => 'field_antigen_modification',
            'unique' => FALSE,
          ),
          12 => array(
            'source' => 'Clone',
            'target' => 'field_clone',
            'unique' => FALSE,
          ),
          13 => array(
            'source' => 'Isotype',
            'target' => 'field_isotype',
            'unique' => FALSE,
          ),
          15 => array(
            'source' => 'Cross Reactivity',
            'target' => 'field_cross_reactivity',
            'unique' => FALSE,
          ),
          16 => array(
            'source' => 'Species Reactivity',
            'target' => 'field_species_reactivity',
            'unique' => FALSE,
          ),
          17 => array(
            'source' => 'Background',
            'target' => 'field_background',
            'unique' => FALSE,
          ),
		  18 => array(
            'source' => 'ALTnames',
            'target' => 'field_altnames',
            'unique' => FALSE,
          ),
          19 => array(
            'source' => 'Epitope',
            'target' => 'field_epitope',
            'unique' => FALSE,
          ),
          20 => array(
            'source' => 'Localization',
            'target' => 'field_localization',
            'unique' => FALSE,
          ),
          21 => array(
            'source' => 'Specificity',
            'target' => 'field_specificity',
            'unique' => FALSE,
          ),
          22 => array(
            'source' => 'Purification',
            'target' => 'field_purification',
            'unique' => FALSE,
          ),
          23 => array(
            'source' => 'Formulation',
            'target' => 'field_formulation',
            'unique' => FALSE,
          ),
          24 => array(
            'source' => 'Reconstition',
            'target' => 'field_reconstition',
            'unique' => FALSE,
          ),
          25 => array(
            'source' => 'Preservative',
            'target' => 'field_preservative',
            'unique' => FALSE,
          ),
          26 => array(
            'source' => 'Concentration',
            'target' => 'field_concentration',
            'unique' => FALSE,
          ),
          27 => array(
            'source' => 'Uses',
            'target' => 'field_uses',
            'unique' => FALSE,
          ),
		  28 => array(
            'source' => 'Application Summary',
            'target' => 'field_application_summary',
            'unique' => FALSE,
          ),
          29 => array(
            'source' => 'Packaging',
            'target' => 'field_packaging',
            'unique' => FALSE,
          ),
          30 => array(
            'source' => 'Storage',
            'target' => 'field_storage',
            'unique' => FALSE,
          ),
          31 => array(
            'source' => 'General References',
            'target' => 'field_general_references',
            'unique' => FALSE,
          ),
          32 => array(
            'source' => 'Product References',
            'target' => 'field_product_references',
            'unique' => FALSE,
          ),
          33 => array(
            'source' => 'Sensitivity',
            'target' => 'field_sensitivity',
            'unique' => FALSE,
          ),
          34 => array(
            'source' => 'Assay Range',
            'target' => 'field_assay_range',
            'unique' => FALSE,
          ),
          35 => array(
            'source' => 'Category',
            'target' => 'field_collection',
            'unique' => FALSE,
          ),
          36 => array(
            'source' => 'Sub-Category',
            'target' => 'field_category',
            'unique' => FALSE,
          ),
		  37 => array(
            'source' => 'BON Cat Number',
            'target' => 'field_sku',
            'unique' => 1,
          ),
                38 => array(
            'source' => 'Vendor Code',
            'target' => 'field_vendor_code',
            'unique' => 1,
          ),
                  39 => array(
            'source' => 'Target Protein',
            'target' => 'field_target_protein',
            'unique' => 1,
          ),
                  40 => array(
            'source' => 'Target Species',
            'target' => 'field_target_species',
            'unique' => 1,
          ),
                  41 => array(
            'source' => 'Accession Number',
            'target' => 'field_accession_number',
            'unique' => 1,
          ),
                  42 => array(
            'source' => 'Host Cell Lines',
            'target' => 'field_host_cell_lines',
            'unique' => 1,
          ),
                  43 => array(
            'source' => 'Assay Protocol',
            'target' => 'field_assay_protocol',
            'unique' => 1,
          ),
        )