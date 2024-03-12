<!-- NEW ARE REGISTRY -->
<div class="col-md-12"><!-- Group 1 -->
  <div class="form-group">
    <h4 class="box-title" align="center"><b>REGISTRY OF NEW ARE-ISSUED PPE</b></h4>
    <div class="horizontal-line"></div>
  </div>
</div>
<!-- End of NEW ARE REGISTRY -->

<!-- Scanned Documents -->
<div class="col-md-3">
  <div class="form-group">
    <label for="scannedDocs">Scanned Documents</label>
    <input type="file" name="scannedDocs" class="form-control" id="scannedDocs" accept=".pdf">
  </div>
</div>
<!-- End Scanned Documents -->

<!-- Date Recorded -->
<div class="col-md-3">
  <div class="form-group">
    <label for="dateReceived"> Date Received</label>
    <input type="date" class="form-control" id="dateReceived" placeholder="Date Recorded" name="dateReceived" autocomplete="off" required max="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>" required>
  </div>
</div>
<!-- End Date Recorded -->

<!-- Article -->
<div class="col-md-3">
  <div class="form-group">
    <label for="article"> Article</label>
    <input type="text" class="form-control" id="article" placeholder="Article" name="article" autocomplete="off" style="text-transform: uppercase;" required>
  </div>
</div>
<!-- End Article -->

<!-- Brand -->
<div class="col-md-3">
  <div class="form-group">
    <label for="brand"> Brand/Model</label>
    <input type="text" class="form-control" id="brand" placeholder="Brand/Model" name="brand" autocomplete="off" style="text-transform: uppercase;" required>
  </div>
</div>
<!-- End Brand -->

<!-- Particulars -->
<div class="col-md-3">
  <div class="form-group">
    <label for="particulars"> Particulars</label>
    <textarea type="text" class="form-control" id="particulars" placeholder="Particulars" name="particulars" autocomplete="off" style="resize: vertical; height: 2.4em;"></textarea>
  </div>
</div>
<!-- End Particulars -->

<!-- Responsibility Center(Office/Department) -->
<div class="col-md-3">
  <div class="form-group">
    <label for="officeName"> Responsibility Center</label>
    <input list="rescenter_options" class="form-control" id="officeName" placeholder="Responsibility Center" name="officeName" autocomplete="off" onchange="fetchEmployeesByCenter()">
    <datalist id="rescenter_options">
        <?php
        $responsibilityCenter = $connect->query("SELECT co.officeID, co.officeName AS officeName, co.officeCodeNumber FROM cityoffices co UNION ALL SELECT no.officeID, no.officeName AS officeName, no.officeCodeNumber FROM nationaloffices no ORDER BY officeName");
        $rowCount = $responsibilityCenter->num_rows;
        if ($rowCount > 0) {
            while ($row = $responsibilityCenter->fetch_assoc()) {
                echo '<option value="'.$row['officeName'].'">'.$row['officeName'].'</option>';
            }
        } else {
            echo '<option value="">No Responsibility Center available</option>';
        }
        ?>
    </datalist>
  </div>
</div>
<!-- End Responsibility Center(Office/Department) -->

<!-- Property Account Code (Classification) -->
<div class="col-md-3">
  <div class="form-group">
    <label for="accountNumber"> Account Code</label>
    <input list="classification_options" class="form-control" id="accountNumber" placeholder="Account Code" name="accountNumber" autocomplete="off" required>
    <datalist id="classification_options">
        <?php
        $query1 = $connect->query("SELECT * FROM account_codes");
        $rowCount = $query1->num_rows;
        if ($rowCount > 0) {
            while ($row = $query1->fetch_assoc()) {
                echo '<option value="' . $row['accountNumber'] . '">' . $row['accountNumber'] . '</option>';
            }
        } else {
            echo '<option value="">No Classifications available</option>';
        }
        ?>
    </datalist>
  </div>
</div>
<!-- End Classification(Property Account Code) -->

<!-- Acquisition Date -->
<div class=" col-md-3">
  <div class="form-group">
    <label for="acquisitionDate"> Acquisition Date</label>
    <input type="date" class="form-control" id="acquisitionDate" placeholder="Acquisition Date" name="acquisitionDate" autocomplete="off">
  </div>
</div>
<!-- End Acquisition Date -->

<!-- Acquisition Cost/Unit Value -->
<div class="col-md-3">
  <div class="form-group">
      <label for="unitValue"> Unit Value</label>
      <input type="text" class="form-control" id="unitValue" placeholder="Unit Value" name="unitValue" autocomplete="off"onblur="validateUnitValue(this)">
      <p id="errorMessage" style="color: red;"></p>
  </div>
</div>

<!-- End Acquisition Cost/Unit Value -->

<!-- Quantity -->
<div class="col-md-3">
  <div class="form-group">
      <label for="balancePerCard"> Quantity</label>
      <input type="number" class="form-control" id="balancePerCard" placeholder="Quantity" name="balancePerCard" autocomplete="off" oninput="updateBalancePerCard()">
  </div>
</div>
<!-- End Quantity -->

<!-- Total Cost/Total Value -->
<div class="col-md-3">
  <div class="form-group">
      <label for="acquisitionCost">Total Value</label>
      <input type="text" class="form-control" id="acquisitionCost" placeholder="Total Value" name="acquisitionCost" readonly>
  </div>
</div>
<!-- End Total Cost/Total Value -->
      
<!-- Unit of Measure -->
<div class="col-md-3">
  <div class="form-group">
    <label for="unitOfMeasure"> Unit of Measure</label>
    <input type="text" class="form-control" id="unitOfMeasure" placeholder="Unit of Measure" name="unitOfMeasure" autocomplete="off">
  </div>
</div>
<!-- End Unit of Measure -->

<div class="col-md-12">
  <table class="table table-bordered" id="dynamicFields">
    <thead>
      <tr>
        <th scope="col" style="text-align: center;">Accountable Employee</th>
        <th scope="col" style="text-align: center;">ARE/MR Number</ th>
        <th scope="col" style="text-align: center;">Serial Number</th>
        <th scope="col" style="text-align: center;">Property Number</th>
        <th scope="col" style="text-align: center;">Location</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <input type="text" class="form-control" name="accountablePerson[]" list="accountable_options" autocomplete="off">
          <datalist id="accountable_options">
            <!-- Options will be dynamically populated via JavaScript -->
          </datalist>
        </td>
        <td><input type="text" class="form-control" name="AREno[]" autocomplete="off"></td>
        <td><textarea type="text" class="form-control" name="serialNo[]" autocomplete="off" style="resize: vertical; height: 2.4em;"></textarea></td>
        <td><input type="text" class="form-control" name="propertyNo[]" autocomplete="off"></td>
        <td><input type="text" class="form-control" name="location[]" autocomplete="off"></td>
        <td><button type="button" class="btn btn-primary add-row">＋</button></td>
      </tr>
    </tbody>
  </table>
</div>


