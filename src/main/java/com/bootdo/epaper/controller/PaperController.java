package com.bootdo.epaper.controller;

import com.bootdo.common.utils.PageUtils;
import com.bootdo.common.utils.Query;
import com.bootdo.common.utils.R;
import com.bootdo.epaper.domain.PaperDO;
import com.bootdo.epaper.service.PaperService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Map;

/**
 * 
 * 
 * @author hzw
 * @email hao17681124518@163.com
 * @date 2018-12-11 21:48:48
 */
 
@Controller
@RequestMapping("/epaper/paper")
public class PaperController {
	@Autowired
	private PaperService paperService;
	
	@GetMapping()
//	@RequiresPermissions("epaper:paper:paper")
	String Paper(){
	    return "epaper/Admin/AddPeriodical";
	}
	
	@ResponseBody
	@GetMapping("/list")
//	@RequiresPermissions("epaper:paper:paper")
	public PageUtils list(@RequestParam Map<String, Object> params){
		//查询列表数据
        Query query = new Query(params);
		List<PaperDO> paperList = paperService.list(query);
		int total = paperService.count(query);
		PageUtils pageUtils = new PageUtils(paperList, total);
		return pageUtils;
	}
	
	@GetMapping("/add")
//	@RequiresPermissions("epaper:paper:add")
	String add(){
	    return "epaper/paper/add";
	}

	@GetMapping("/edit/{id}")
//	@RequiresPermissions("epaper:paper:edit")
	String edit(@PathVariable("id") Long id,Model model){
		PaperDO paper = paperService.get(id);
		model.addAttribute("paper", paper);
	    return "epaper/paper/edit";
	}
	
	/**
	 * 保存
	 */
	@ResponseBody
	@PostMapping("/save")
//	@RequiresPermissions("epaper:paper:add")
	public R save( PaperDO paper){
		if(paperService.save(paper)>0){
			return R.ok();
		}
		return R.error();
	}
	/**
	 * 修改
	 */
	@ResponseBody
	@RequestMapping("/update")
//	@RequiresPermissions("epaper:paper:edit")
	public R update( PaperDO paper){
		paperService.update(paper);
		return R.ok();
	}
	
	/**
	 * 删除
	 */
	@PostMapping( "/remove")
	@ResponseBody
//	@RequiresPermissions("epaper:paper:remove")
	public R remove( Long id){
		if(paperService.remove(id)>0){
		return R.ok();
		}
		return R.error();
	}
	
	/**
	 * 删除
	 */
	@PostMapping( "/batchRemove")
	@ResponseBody
//	@RequiresPermissions("epaper:paper:batchRemove")
	public R remove(@RequestParam("ids[]") Long[] ids){
		paperService.batchRemove(ids);
		return R.ok();
	}
	
}
